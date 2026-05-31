<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryawanModel;
use App\Models\PresensiModel;
use App\Models\PengajuanIzinModel;
use App\Models\PenggajianModel;
use App\Models\KomponenGajiModel;
use App\Services\MidtransIrisService;
use Carbon\Carbon;

class PenggajianController extends Controller
{
    // Halaman generate gaji
    public function payrollIndex(Request $request)
    {
        $bulanTerpilih = $request->get('periode', date('Y-m'));
        $karyawans = KaryawanModel::all();

        $totalHariKerja = 26;

        $dataGaji = [];

        foreach ($karyawans as $karyawan) {
            $komponen = KomponenGajiModel::where('id_karyawan', $karyawan->id_karyawan)->first();
            $gajiPokok = $komponen ? $komponen->gaji_pokok : 3000000;
            $tunjanganJabatan = $komponen ? $komponen->tunjangan_jabatan : 0;
            $insentifSkill = $komponen ? $komponen->insentif_skill : 0;

            $potonganPerHari = round($gajiPokok / $totalHariKerja);

            $gajiTersimpan = PenggajianModel::where('id_karyawan', $karyawan->id_karyawan)
                ->where('periode', $bulanTerpilih)
                ->first();

            if ($gajiTersimpan) {
                $totalAbsen = $totalHariKerja - $gajiTersimpan->jumlah_hadir;
                if ($totalAbsen < 0)
                    $totalAbsen = 0;
                $totalPotonganBaru = $totalAbsen * $potonganPerHari;
                $totalBersihBaru = ($gajiPokok - $totalPotonganBaru) + $tunjanganJabatan + $insentifSkill;

                if (($gajiTersimpan->gaji_pokok != $gajiPokok || $gajiTersimpan->total_potongan != $totalPotonganBaru || $gajiTersimpan->total_gaji != $totalBersihBaru) && $gajiTersimpan->status_pembayaran != 'lunas') {
                    $gajiTersimpan->update([
                        'gaji_pokok' => $gajiPokok,
                        'total_potongan' => $totalPotonganBaru,
                        'total_gaji' => $totalBersihBaru
                    ]);
                }

                $dataGaji[] = [
                    'karyawan' => $karyawan,
                    'is_generated' => true,
                    'penggajian' => $gajiTersimpan,
                    'gaji_pokok' => $gajiPokok,
                    'tunjangan_jabatan' => $tunjanganJabatan,
                    'insentif_skill' => $insentifSkill,
                    'total_potongan' => $gajiTersimpan->total_potongan,
                    'total_gaji' => $gajiTersimpan->total_gaji
                ];
            } else {
                $startOfMonth = Carbon::createFromFormat('Y-m', $bulanTerpilih)->startOfMonth();
                $endOfMonth = Carbon::createFromFormat('Y-m', $bulanTerpilih)->endOfMonth();

                // 1. Hitung Jumlah Hadir (jumlah hari unik dimana karyawan absen 'masuk')
                $jumlahHadir = PresensiModel::where('id_karyawan', $karyawan->id_karyawan)
                    ->where('type', 'masuk')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->selectRaw('DATE(created_at) as tanggal')
                    ->groupBy('tanggal')
                    ->get()
                    ->count();

                // 2. Hitung Izin & Sakit yang disetujui (diff in days + 1)
                $pengajuans = PengajuanIzinModel::where('id_karyawan', $karyawan->id_karyawan)
                    ->where('status', 'disetujui')
                    ->whereBetween('tanggal_mulai', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                    ->get();

                $jumlahIzin = 0;
                $jumlahSakit = 0;

                foreach ($pengajuans as $p) {
                    $start = Carbon::parse($p->tanggal_mulai);
                    $end = Carbon::parse($p->tanggal_selesai);
                    $hari = $start->diffInDays($end) + 1;

                    if ($p->jenis == 'izin') {
                        $jumlahIzin += $hari;
                    } else {
                        $jumlahSakit += $hari;
                    }
                }

                // 3. Hitung Alpa
                $jumlahAlpa = $totalHariKerja - $jumlahHadir - $jumlahIzin - $jumlahSakit;
                if ($jumlahAlpa < 0)
                    $jumlahAlpa = 0;

                // 4. Kalkulasi Uang 
                $totalAbsen = $totalHariKerja - $jumlahHadir;
                if ($totalAbsen < 0)
                    $totalAbsen = 0;

                $totalPotongan = $totalAbsen * $potonganPerHari;
                $totalBersih = ($gajiPokok - $totalPotongan) + $tunjanganJabatan + $insentifSkill;

                $dataGaji[] = [
                    'karyawan' => $karyawan,
                    'is_generated' => false,
                    'gaji_pokok' => $gajiPokok,
                    'tunjangan_jabatan' => $tunjanganJabatan,
                    'insentif_skill' => $insentifSkill,
                    'jumlah_hadir' => $jumlahHadir,
                    'jumlah_izin' => $jumlahIzin,
                    'jumlah_sakit' => $jumlahSakit,
                    'jumlah_alpa' => $jumlahAlpa,
                    'total_potongan' => $totalPotongan,
                    'total_gaji' => $totalBersih
                ];
            }
        }

        return view('admin.penggajian.payroll', compact('bulanTerpilih', 'dataGaji'));
    }

    // Fungsi menyimpan / meng-generate gaji karyawan
    public function generate(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required',
            'periode' => 'required',
            'gaji_pokok' => 'required|numeric',
            'jumlah_hadir' => 'required|numeric',
            'jumlah_izin' => 'required|numeric',
            'jumlah_sakit' => 'required|numeric',
            'jumlah_alpa' => 'required|numeric',
            'total_potongan' => 'required|numeric',
            'total_gaji' => 'required|numeric',
        ]);

        PenggajianModel::updateOrCreate(
            [
                'id_karyawan' => $request->id_karyawan,
                'periode' => $request->periode
            ],
            [
                'gaji_pokok' => $request->gaji_pokok,
                'jumlah_hadir' => $request->jumlah_hadir,
                'jumlah_izin' => $request->jumlah_izin,
                'jumlah_sakit' => $request->jumlah_sakit,
                'jumlah_alpa' => $request->jumlah_alpa,
                'total_potongan' => $request->total_potongan,
                'total_gaji' => $request->total_gaji,
                'status_pembayaran' => 'tertunda'
            ]
        );

        return redirect()->back()->with('success', 'Gaji berhasil digenerate dan tersimpan.');
    }

    public function tandaiLunas($id)
    {
        $gaji = PenggajianModel::findOrFail($id);
        $gaji->update(['status_pembayaran' => 'lunas']);
        return redirect()->back()->with('success', 'Gaji sudah dibayarkan.');
    }

    public function prosesPembayaran(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,transfer'
        ]);

        $gaji = PenggajianModel::with('karyawan')->findOrFail($id);
        $metode = $request->metode_pembayaran;

        if ($metode === 'tunai') {
            $gaji->update([
                'metode_pembayaran' => 'tunai',
                'status_pembayaran' => 'lunas'
            ]);
            return redirect()->back()->with('success', 'Gaji sudah dibayarkan secara tunai.');
        }

        if ($metode === 'transfer') {
            $karyawan = $gaji->karyawan;
            if (!$karyawan->nama_bank || !$karyawan->no_rekening) {
                return redirect()->back()->with('error', 'Data bank karyawan belum lengkap.');
            }

            $referenceNo = 'PAY-' . $gaji->id_penggajian . '-' . time();
            $amount = $gaji->total_gaji;

            $irisService = new MidtransIrisService();
            $response = $irisService->createPayout(
                $referenceNo,
                $amount,
                $karyawan->nama,
                $karyawan->no_rekening,
                $karyawan->nama_bank,
                $karyawan->email
            );

            if ($response['success']) {
                $gaji->update([
                    'metode_pembayaran' => 'transfer',
                    'midtrans_reference_no' => $response['data']['reference_no'] ?? $referenceNo,
                    'midtrans_status' => 'queued',
                    'status_pembayaran' => 'proses_transfer'
                ]);
                return redirect()->back()->with('success', 'Transfer sedang diproses oleh sistem Midtrans.');
            } else {
                return redirect()->back()->with('error', 'Gagal memproses transfer: ' . json_encode($response['message']));
            }
        }
    }

    // Halaman list Slip Gaji (Arsip)
    public function slipGajiIndex(Request $request)
    {
        $bulanTerpilih = $request->get('periode', date('Y-m'));
        $penggajians = PenggajianModel::with(['karyawan', 'komponenGaji'])
            ->where('periode', $bulanTerpilih)
            ->get();

        return view('admin.penggajian.slip_gaji', compact('penggajians', 'bulanTerpilih'));
    }

    public function cetakSlip($id)
    {
        $gaji = PenggajianModel::with(['karyawan', 'komponenGaji'])->findOrFail($id);
        return view('admin.penggajian.cetak', compact('gaji'));
    }

    // --- FITUR KARYAWAN ---

    public function karyawanSlipGaji(Request $request)
    {
        $bulanTerpilih = $request->get('periode', date('Y-m'));
        $userId = \Illuminate\Support\Facades\Auth::id();

        $penggajians = PenggajianModel::with(['karyawan', 'komponenGaji'])
            ->where('id_karyawan', $userId)
            ->where('periode', $bulanTerpilih)
            ->get();

        return view('karyawan.slip_gaji', compact('penggajians', 'bulanTerpilih'));
    }

    public function cetakSlipKaryawan($id)
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $gaji = PenggajianModel::with(['karyawan', 'komponenGaji'])
            ->where('id_karyawan', $userId)
            ->findOrFail($id);

        // We can reuse the admin's print view because it's just a printable invoice format without layouts
        return view('admin.penggajian.cetak', compact('gaji'));
    }
}
