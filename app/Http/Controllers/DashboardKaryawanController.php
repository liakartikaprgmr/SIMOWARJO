<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresensiModel;
use App\Models\PenjadwalanModel;
use App\Models\PengajuanIzinModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardKaryawanController extends Controller
{
    public function dashboard()
    {
        $karyawan = Auth::user();
        if (!$karyawan) {
            return redirect('/login');
        }

        $id_karyawan = $karyawan->id_karyawan;
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Status Kehadiran Hari Ini
        $presensiHariIni = PresensiModel::where('id_karyawan', $id_karyawan)
            ->whereDate('created_at', $today)
            ->where('type', 'masuk')
            ->first();
        $statusHadir = $presensiHariIni ? 'Sudah Absen' : 'Belum Absen';

        // 2. Kehadiran Bulan Ini
        $totalHadirBulanIni = PresensiModel::where('id_karyawan', $id_karyawan)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('type', 'masuk')
            ->count();

        // 3. Shift Hari Ini
        $jadwalHariIni = PenjadwalanModel::where('id_karyawan', $id_karyawan)
            ->whereDate('tanggal', $today)
            ->first();
        $shiftHariIni = $jadwalHariIni ? $jadwalHariIni->shift : 'Libur/Tidak Ada';

        // 4. Perizinan Pending
        $perizinanPending = PengajuanIzinModel::where('id_karyawan', $id_karyawan)
            ->where('status', 'pending')
            ->count();

        return view('karyawan.dashboardempl', compact(
            'karyawan',
            'statusHadir',
            'totalHadirBulanIni',
            'shiftHariIni',
            'perizinanPending'
        ));
    }
}
