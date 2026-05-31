<?php

namespace App\Http\Controllers;

use App\Models\KeuanganModel;
use App\Models\PenjualanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\KeuanganExport;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    //Dashboard Keuangan
    public function dashboard(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        // 1. Omzet Hari Ini
        $omzetHariIni = KeuanganModel::pemasukan()
            ->whereDate('tanggal', now()->toDateString())
            ->whereIn('kategori', ['Penjualan harian', 'sales'])
            ->sum('jumlah');

        // 2. Cash In vs Cash Out (Bulan Ini)
        $totalPemasukan = KeuanganModel::periode($bulan, $tahun)->pemasukan()->sum('jumlah');
        $totalPengeluaran = KeuanganModel::periode($bulan, $tahun)->pengeluaran()->sum('jumlah');

        // 3. Laba Estimasi
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        // 4. Grafik Penjualan (Harian Bulan Ini)
        $start = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $end = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $chartLabels = [];
        $chartPenjualan = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $tgl = $d->toDateString();
            $chartLabels[] = $d->format('d');
            $chartPenjualan[] = (float) KeuanganModel::whereDate('tanggal', $tgl)
                ->whereIn('kategori', ['Penjualan harian', 'sales'])
                ->sum('jumlah');
        }

        // 5. Pengeluaran Terbesar (Bulan Ini)
        $pengeluaranTerbesar = KeuanganModel::periode($bulan, $tahun)
            ->pengeluaran()
            ->orderByDesc('jumlah')
            ->first();

        // 6. Saldo Kas (Sepanjang Waktu)
        $saldoKas = KeuanganModel::pemasukan()->sum('jumlah') - KeuanganModel::pengeluaran()->sum('jumlah');

        // 7. Performa Shift (Bulan Ini)
        $performaShift = PenjualanHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('shift, SUM(total_penjualan) as total')
            ->groupBy('shift')
            ->pluck('total', 'shift');

        // Transaksi terbaru
        $transaksiTerbaru = KeuanganModel::periode($bulan, $tahun)
            ->with('pembuat')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $bulanList = collect(range(1, 12))->map(fn($b) => [
            'value' => $b,
            'label' => Carbon::createFromDate($tahun, $b, 1)->isoFormat('MMMM'),
        ]);
        $tahunList = range(now()->year - 2, now()->year + 1);

        return view('admin.Kelola_Keuangan.dashboard', compact(
            'bulan',
            'tahun',
            'bulanList',
            'tahunList',
            'omzetHariIni',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih',
            'chartLabels',
            'chartPenjualan',
            'pengeluaranTerbesar',
            'saldoKas',
            'performaShift',
            'transaksiTerbaru'
        ));
    }

    //Penjualan Harian
    public function penjualanIndex(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $sales = PenjualanHarian::with(['pembuat', 'details'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $totalBulanIni = PenjualanHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('total_penjualan');

        $bulanList = collect(range(1, 12))->map(fn($b) => [
            'value' => $b,
            'label' => Carbon::createFromDate($tahun, $b, 1)->isoFormat('MMMM'),
        ]);
        $tahunList = range(now()->year - 2, now()->year + 1);

        return view('admin.Kelola_Keuangan.sales.index', compact(
            'sales',
            'bulan',
            'tahun',
            'bulanList',
            'tahunList',
            'totalBulanIni'
        ));
    }

    public function salesCreate()
    {
        return view('admin.Kelola_Keuangan.sales.create');
    }

    public function salesStore(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang,malam',
            'total_penjualan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        PenjualanHarian::create([
            'tanggal' => $request->tanggal,
            'shift' => $request->shift,
            'total_penjualan' => $request->total_penjualan,
            'keterangan' => $request->keterangan,
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->route('admin.kelola_keuangan.sales.index')
            ->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function salesShow(PenjualanHarian $sales)
    {
        $sales->load('pembuat');
        return view('admin.Kelola_Keuangan.sales.show', compact('sales'));
    }

    public function salesDestroy(PenjualanHarian $sales)
    {
        $sales->delete();

        return redirect()->route('admin.kelola_keuangan.sales.index')
            ->with('success', 'Data penjualan berhasil dihapus.');
    }

    // Cashflow

    public function cashflowIndex(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $transaksi = KeuanganModel::periode($bulan, $tahun)
            ->with('pembuat')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('jumlah');
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        $bulanList = collect(range(1, 12))->map(fn($b) => [
            'value' => $b,
            'label' => Carbon::createFromDate($tahun, $b, 1)->isoFormat('MMMM'),
        ]);
        $tahunList = range(now()->year - 2, now()->year + 1);

        return view('admin.Kelola_Keuangan.cashflow.index', compact(
            'transaksi',
            'bulan',
            'tahun',
            'bulanList',
            'tahunList',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih'
        ));
    }

    public function cashflowStore(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:50',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        KeuanganModel::create([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->route('admin.kelola_keuangan.cashflow.index')
            ->with('success', 'Transaksi kas berhasil dicatat.');
    }

    //Laporan Cash Flow
    public function laporanIndex(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $transaksi = KeuanganModel::periode($bulan, $tahun)
            ->with('pembuat')
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('jumlah');
        $labaBersih = $totalPemasukan - $totalPengeluaran;

        // Ringkasan per kategori
        $ringkasanPemasukan = $transaksi->where('jenis', 'pemasukan')
            ->groupBy('kategori')
            ->map(fn($g) => $g->sum('jumlah'));

        $ringkasanPengeluaran = $transaksi->where('jenis', 'pengeluaran')
            ->groupBy('kategori')
            ->map(fn($g) => $g->sum('jumlah'));

        $bulanList = collect(range(1, 12))->map(fn($b) => [
            'value' => $b,
            'label' => Carbon::createFromDate($tahun, $b, 1)->isoFormat('MMMM'),
        ]);
        $tahunList = range(now()->year - 2, now()->year + 1);

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM');

        return view('admin.Kelola_Keuangan.laporan.index', compact(
            'transaksi',
            'bulan',
            'tahun',
            'namaBulan',
            'bulanList',
            'tahunList',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih',
            'ringkasanPemasukan',
            'ringkasanPengeluaran'
        ));
    }

    public function laporanExportPdf(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $transaksi = KeuanganModel::periode($bulan, $tahun)
            ->with('pembuat')
            ->orderBy('tanggal')
            ->orderBy('jenis')
            ->get();

        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('jumlah');
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM');

        $pdf = Pdf::loadview('admin.Kelola_Keuangan.laporan.pdf', compact(
            'transaksi',
            'bulan',
            'tahun',
            'namaBulan',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("laporan_keuangan_{$namaBulan}_{$tahun}.pdf");
    }

    public function laporanExportExcel(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM');

        return Excel::download(
            new KeuanganExport($bulan, $tahun),
            "laporan_keuangan_{$namaBulan}_{$tahun}.xlsx"
        );
    }
}
