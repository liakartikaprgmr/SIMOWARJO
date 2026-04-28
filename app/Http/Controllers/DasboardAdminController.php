<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryawanModel;
use App\Models\PresensiModel;
use App\Models\PengajuanIzinModel;
use App\Models\PenggajianModel;
use Carbon\Carbon;

class DasboardAdminController extends Controller
{
    public function dashboard()
    {
        //Total Karyawan
        $totalKaryawan = KaryawanModel::count();

        //Kehadiran Hari Ini
        $kehadiranHariIni = PresensiModel::whereDate('created_at', Carbon::today())->count();

        //Perizinan Menunggu
        $perizinanPending = PengajuanIzinModel::where('status', 'pending')->count();

        //Penggajian Bulan Ini (Format periode "YYYY-MM")
        $currentMonth = Carbon::now()->format('Y-m');
        $penggajianBulanIni = PenggajianModel::where('periode', $currentMonth)->sum('total_gaji');
        if ($penggajianBulanIni == 0) {
            $penggajianBulanIni = PenggajianModel::whereMonth('created_at', Carbon::now()->month)->sum('total_gaji');
        }

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $presensiData = PresensiModel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $chartLabels[] = $date->locale('id')->isoFormat('dddd'); // Nama hari
            $chartData[] = isset($presensiData[$dateStr]) ? $presensiData[$dateStr]->count : 0;
        }

        // --- Data untuk Pie Chart (Status Karyawan) ---
        $karyawanAktif = KaryawanModel::where('status', 'aktif')->count();
        $karyawanTidakAktif = KaryawanModel::where('status', 'tidak_aktif')->count();

        return view('admin.dashboard_admin', compact(
            'totalKaryawan',
            'kehadiranHariIni',
            'perizinanPending',
            'penggajianBulanIni',
            'chartLabels',
            'chartData',
            'karyawanAktif',
            'karyawanTidakAktif'
        ));
    }
}
