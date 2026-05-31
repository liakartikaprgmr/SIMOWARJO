<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryawanModel;
use App\Models\PresensiModel;
use App\Models\PengajuanIzinModel;
use App\Models\PenggajianModel;
use App\Models\KeuanganModel;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Carbon\Carbon;

class DasboardAdminController extends Controller
{
    public function dashboard()
    {
        // 1. Total Karyawan
        $totalKaryawan = KaryawanModel::count();

        // 2. Kehadiran Hari Ini
        $kehadiranHariIni = PresensiModel::whereDate('created_at', Carbon::today())->count();

        // 3. Perizinan Menunggu (Pending)
        $perizinanPending = PengajuanIzinModel::where('status', 'pending')->count();

        // 4. Pendapatan Bulan Ini 
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $pendapatanBulanIni = KeuanganModel::pemasukan()
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('jumlah');

        // 5. Total Stok Barang (Sum of 'stok_saat_ini' in 'barang' table)
        $totalStokBarang = Barang::sum('stok_saat_ini');

        // 6. Statistik Pendapatan vs Pengeluaran (6 Bulan Terakhir)
        $financialLabels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $financialLabels[] = $month->locale('id')->isoFormat('MMMM YYYY');

            $incomeData[] = (float) KeuanganModel::pemasukan()
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');

            $expenseData[] = (float) KeuanganModel::pengeluaran()
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');
        }

        // 7. Distribusi Stok Barang per Kategori (untuk Doughnut Chart)
        $kategoriStock = KategoriBarang::with(['barang'])->get()->map(function ($kat) {
            return [
                'nama' => $kat->nama,
                'stok' => (int) $kat->barang->sum('stok_saat_ini')
            ];
        })->filter(function ($item) {
            return $item['stok'] > 0;
        })->values();

        $kategoriLabels = $kategoriStock->pluck('nama')->toArray();
        $kategoriData = $kategoriStock->pluck('stok')->toArray();

        return view('admin.dashboard_admin', compact(
            'totalKaryawan',
            'kehadiranHariIni',
            'perizinanPending',
            'pendapatanBulanIni',
            'totalStokBarang',
            'financialLabels',
            'incomeData',
            'expenseData',
            'kategoriLabels',
            'kategoriData'
        ));
    }
}

