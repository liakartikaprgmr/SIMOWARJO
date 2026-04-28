<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanIzinModel;

class PerizinanController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanIzinModel::with('karyawan')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.perizinan.index', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);

        $izin = PengajuanIzinModel::findOrFail($id);
        $izin->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pengajuan perizinan berhasil diupdate.');
    }

    public function createIzin()
    {
        $riwayatIzin = PengajuanIzinModel::where('id_karyawan', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('karyawan.izin', [
            'kategoriFilter' => 'izin',
            'riwayatIzin' => $riwayatIzin
        ]);
    }

    public function createSakit()
    {
        $riwayatIzin = PengajuanIzinModel::where('id_karyawan', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('karyawan.izin', [
            'kategoriFilter' => 'sakit',
            'riwayatIzin' => $riwayatIzin
        ]);
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis' => 'required|in:izin,sakit',
            'keterangan' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('bukti_foto');
        $data['id_karyawan'] = auth()->id();
        $data['status'] = 'pending';

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_izin', $filename, 'public');
            $data['bukti_foto'] = $path;
        }

        PengajuanIzinModel::create($data);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim.');
    }
}
