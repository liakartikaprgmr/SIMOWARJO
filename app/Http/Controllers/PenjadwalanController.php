<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjadwalanModel;
use App\Models\KaryawanModel;
use Carbon\Carbon;

class PenjadwalanController extends Controller
{
    // Tampilkan semua jadwal di tabel Admin (Dikelompokkan)
    public function indexAdmin(Request $request)
    {
        $allSchedules = PenjadwalanModel::with('karyawan')->orderBy('tanggal', 'asc')->get();

        $penjadwalan = [];
        
        // Mengelompokkan berdasarkan Karyawan dan Shift berurutan/sama
        foreach ($allSchedules->groupBy('id_karyawan') as $karyawanId => $schedules) {
            $currentGroup = null;
            
            foreach ($schedules as $jadwal) {
                if (!$currentGroup) {
                    $currentGroup = [
                        'karyawan' => $jadwal->karyawan,
                        'id_karyawan' => $jadwal->id_karyawan,
                        'shift' => $jadwal->shift,
                        'jam_masuk' => $jadwal->jam_masuk,
                        'jam_pulang' => $jadwal->jam_pulang,
                        'tanggal_mulai' => $jadwal->tanggal,
                        'tanggal_selesai' => $jadwal->tanggal,
                        'ids' => [$jadwal->id_jadwalan]
                    ];
                } else {
                    $prevDate = Carbon::parse($currentGroup['tanggal_selesai']);
                    $currDate = Carbon::parse($jadwal->tanggal);
                    
                    if ($jadwal->shift == $currentGroup['shift'] && $prevDate->diffInDays($currDate) == 1) {
                        $currentGroup['tanggal_selesai'] = $jadwal->tanggal;
                        $currentGroup['ids'][] = $jadwal->id_jadwalan;
                    } else {
                        $penjadwalan[] = (object) $currentGroup;
                        $currentGroup = [
                            'karyawan' => $jadwal->karyawan,
                            'id_karyawan' => $jadwal->id_karyawan,
                            'shift' => $jadwal->shift,
                            'jam_masuk' => $jadwal->jam_masuk,
                            'jam_pulang' => $jadwal->jam_pulang,
                            'tanggal_mulai' => $jadwal->tanggal,
                            'tanggal_selesai' => $jadwal->tanggal,
                            'ids' => [$jadwal->id_jadwalan]
                        ];
                    }
                }
            }
            if ($currentGroup) {
                $penjadwalan[] = (object) $currentGroup;
            }
        }
        
        $penjadwalan = collect($penjadwalan)->sortByDesc('tanggal_mulai')->values();

        return view('admin.penjadwalan.index', compact('penjadwalan'));
    }

    public function create()
    {
        $karyawans = KaryawanModel::all();
        return view('admin.penjadwalan.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'shift' => 'required|in:Pagi,Malam',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_selesai);
        $karyawanId = $request->id_karyawan;

        // Validasi: Pastikan tidak ada satupun tanggal di rentang ini yang sudah punya jadwal
        $conflictExists = PenjadwalanModel::where('id_karyawan', $karyawanId)
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->exists();

        if ($conflictExists) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Karyawan ini sudah memiliki jadwal pada salah satu atau beberapa tanggal di rentang waktu tersebut.');
        }

        // Loop dan simpan tiap hari
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            PenjadwalanModel::create([
                'id_karyawan' => $karyawanId,
                'shift' => $request->shift,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'tanggal' => $currentDate->format('Y-m-d'),
            ]);
            
            $currentDate->addDay();
        }

        return redirect()->route('admin.penjadwalan.index')->with('success', 'Jadwal shift berulang berhasil ditambahkan.');
    }

    // Tampilkan form edit berulang (Admin)
    public function editBulk(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (empty($ids) || !$request->ids) {
            return redirect()->route('admin.penjadwalan.index')->with('error', 'Data tidak valid.');
        }

        $jadwals = PenjadwalanModel::whereIn('id_jadwalan', $ids)->orderBy('tanggal', 'asc')->get();
        if ($jadwals->isEmpty()) {
            return redirect()->route('admin.penjadwalan.index')->with('error', 'Jadwal tidak ditemukan.');
        }

        $jadwalData = (object) [
            'id_karyawan' => $jadwals->first()->id_karyawan,
            'karyawan' => $jadwals->first()->karyawan,
            'shift' => $jadwals->first()->shift,
            'jam_masuk' => $jadwals->first()->jam_masuk,
            'jam_pulang' => $jadwals->first()->jam_pulang,
            'tanggal_mulai' => $jadwals->first()->tanggal,
            'tanggal_selesai' => $jadwals->last()->tanggal,
            'ids_string' => $request->ids
        ];

        $karyawans = KaryawanModel::all();
        return view('admin.penjadwalan.edit', compact('jadwalData', 'karyawans'));
    }

    // Update jadwal berulang (Admin)
    public function updateBulk(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'shift' => 'required|in:Pagi,Malam',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'ids_string' => 'required'
        ]);

        $oldIds = explode(',', $request->ids_string);
        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_selesai);
        $karyawanId = $request->id_karyawan;

        // Cek bentrok (kecuali dengan dirinya sendiri yang sedang diedit)
        $conflictExists = PenjadwalanModel::where('id_karyawan', $karyawanId)
            ->whereNotIn('id_jadwalan', $oldIds)
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->exists();

        if ($conflictExists) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Karyawan ini sudah memiliki jadwal lain pada tanggal tersebut.');
        }

        // Hapus jadwal lama
        PenjadwalanModel::whereIn('id_jadwalan', $oldIds)->delete();

        // Buat jadwal baru
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            PenjadwalanModel::create([
                'id_karyawan' => $karyawanId,
                'shift' => $request->shift,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'tanggal' => $currentDate->format('Y-m-d'),
            ]);
            $currentDate->addDay();
        }

        return redirect()->route('admin.penjadwalan.index')->with('success', 'Jadwal shift berhasil diperbarui.');
    }

    // Hapus jadwal berulang (Admin)
    public function deleteBulk(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (!empty($ids) && $request->ids) {
            PenjadwalanModel::whereIn('id_jadwalan', $ids)->delete();
        }

        return redirect()->route('admin.penjadwalan.index')->with('success', 'Jadwal shift berhasil dihapus.');
    }

    // ==========================================
    // KARYAWAN ROUTES
    // ==========================================

    // Tampilkan jadwal untuk Karyawan (Satu Minggu Berjalan)
    public function indexKaryawan(Request $request)
    {
        $id_karyawan = auth()->user()->id_karyawan;

        // Ambil hari senin dan minggu di minggu berjalan ini
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $jadwal_kerja = PenjadwalanModel::where('id_karyawan', $id_karyawan)
            ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('karyawan.jadwal_kerja', compact('jadwal_kerja', 'startOfWeek', 'endOfWeek'));
    }
}
