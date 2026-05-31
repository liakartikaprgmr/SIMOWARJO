<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\DashboardKaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\KeuanganController;



Route::get('/', function () {
    return view('welcome');
});

//Route Proses Autentication
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route untuk admin
Route::get('/admin/dashboard', [DasboardAdminController::class, 'dashboard'])->name('admin.dashboard');

// Route untuk karyawan
Route::get('/karyawan/dashboard', [DashboardKaryawanController::class, 'dashboard'])->name('karyawan.dashboard');
Route::get('/karyawan/presensi', [PresensiController::class, 'index'])->name('karyawan.presensi');
Route::post('/presensi/upload', [PresensiController::class, 'upload'])->name('presensi.upload');


// Rute Admin (Persetujuan Izin & Penggajian)
Route::prefix('admin')->name('admin.')->group(function () {
    // Kelola Karyawan (CRUD)
    Route::get('/kelola_karyawan', [KaryawanController::class, 'kelola_karyawan'])->name('kelola_karyawan');
    Route::get('/tambah_karyawan', [KaryawanController::class, 'tambah_karyawan'])->name('tambah_karyawan');
    Route::post('/tambah_karyawan', [KaryawanController::class, 'store_karyawan'])->name('store_karyawan');
    Route::get('/edit_karyawan/{id}', [KaryawanController::class, 'edit_karyawan'])->name('edit_karyawan');
    Route::post('/update_karyawan/{id}', [KaryawanController::class, 'update_karyawan'])->name('update_karyawan');
    Route::delete('/delete_karyawan/{id}', [KaryawanController::class, 'delete_karyawan'])->name('delete_karyawan');

    // Penjadwalan
    Route::get('/penjadwalan', [PenjadwalanController::class, 'indexAdmin'])->name('penjadwalan.index');
    Route::get('/penjadwalan/create', [PenjadwalanController::class, 'create'])->name('penjadwalan.create');
    Route::post('/penjadwalan/store', [PenjadwalanController::class, 'store'])->name('penjadwalan.store');
    Route::get('/penjadwalan/edit-bulk', [PenjadwalanController::class, 'editBulk'])->name('penjadwalan.edit_bulk');
    Route::post('/penjadwalan/update-bulk', [PenjadwalanController::class, 'updateBulk'])->name('penjadwalan.update_bulk');
    Route::post('/penjadwalan/delete-bulk', [PenjadwalanController::class, 'deleteBulk'])->name('penjadwalan.delete_bulk');

    // Legacy routes (optional)
    Route::get('/penjadwalan/edit/{id}', [PenjadwalanController::class, 'edit'])->name('penjadwalan.edit');
    Route::post('/penjadwalan/update/{id}', [PenjadwalanController::class, 'update'])->name('penjadwalan.update');
    Route::delete('/penjadwalan/delete/{id}', [PenjadwalanController::class, 'delete'])->name('penjadwalan.delete');

    // Perizinan
    Route::get('/perizinan/persetujuan', [\App\Http\Controllers\PerizinanController::class, 'index'])->name('perizinan.index');
    Route::post('/perizinan/persetujuan/{id}', [\App\Http\Controllers\PerizinanController::class, 'updateStatus'])->name('perizinan.update_status');

    // Geolokasi
    Route::get('/geolokasi', [\App\Http\Controllers\GeolokasiController::class, 'index'])->name('geolokasi.index');
    Route::post('/geolokasi', [\App\Http\Controllers\GeolokasiController::class, 'update'])->name('geolokasi.update');

    // Presensi Wajah & Kehadiran (Supervisor)
    Route::get('/presensi-wajah', [PresensiController::class, 'adminPresensi'])->name('presensi_wajah');
    Route::get('/presensi/kehadiran', [PresensiController::class, 'daftarKehadiran'])->name('presensi.kehadiran');

    // Komponen Gaji
    Route::get('/penggajian/komponen-gaji', [\App\Http\Controllers\KomponenGajiController::class, 'index'])->name('penggajian.komponen_gaji.index');
    Route::post('/penggajian/komponen-gaji/update', [\App\Http\Controllers\KomponenGajiController::class, 'update'])->name('penggajian.komponen_gaji.update');

    // Penggajian (Sidebar -> Kelola Penggajian)
    Route::get('/penggajian/payroll', [PenggajianController::class, 'payrollIndex'])->name('penggajian.payroll');
    Route::post('/penggajian/generate', [PenggajianController::class, 'generate'])->name('penggajian.generate');
    Route::post('/penggajian/lunas/{id}', [PenggajianController::class, 'tandaiLunas'])->name('penggajian.lunas');
    Route::post('/penggajian/{id}/bayar', [PenggajianController::class, 'prosesPembayaran'])->name('penggajian.bayar');

    Route::get('/penggajian/slip-gaji', [PenggajianController::class, 'slipGajiIndex'])->name('penggajian.slip_gaji');
    Route::get('/penggajian/cetak/{id}', [PenggajianController::class, 'cetakSlip'])->name('penggajian.cetak');
});

// Rute Tambahan untuk Karyawan (Pengajuan Izin)
Route::prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/jadwal-kerja', [PenjadwalanController::class, 'indexKaryawan'])->name('jadwal_kerja');

    Route::get('/izin', [\App\Http\Controllers\PerizinanController::class, 'createIzin'])->name('izin');
    Route::post('/izin', [\App\Http\Controllers\PerizinanController::class, 'storeIzin'])->name('izin.store');

    Route::get('/sick-leave', [\App\Http\Controllers\PerizinanController::class, 'createSakit'])->name('sick_leave');

    Route::get('/slip-gaji', [\App\Http\Controllers\PenggajianController::class, 'karyawanSlipGaji'])->name('slip_gaji');
    Route::get('/slip-gaji/cetak/{id}', [\App\Http\Controllers\PenggajianController::class, 'cetakSlipKaryawan'])->name('cetak_slip');
});

// Stok Barang (supervisor & leader_shift)
Route::prefix('admin/kelola_barang')->name('admin.kelola_barang.')->middleware('role:supervisor,leader_shift')->group(function () {
    Route::get('/', [StokController::class, 'index'])->name('index');
    Route::get('/tambah', [StokController::class, 'create'])->name('create');
    Route::post('/tambah', [StokController::class, 'store'])->name('store');
    Route::get('/{barang}/edit', [StokController::class, 'edit'])->name('edit');
    Route::put('/{barang}', [StokController::class, 'update'])->name('update');
    Route::delete('/{barang}', [StokController::class, 'destroy'])->name('destroy');

    Route::get('/masuk', [BarangMasukController::class, 'index'])->name('masuk');
    Route::post('/masuk', [BarangMasukController::class, 'store'])->name('masuk.store');
    Route::delete('/masuk/{barangMasuk}', [BarangMasukController::class, 'destroy'])->name('masuk.destroy');

    Route::get('/keluar', [BarangKeluarController::class, 'index'])->name('keluar');
    Route::post('/keluar', [BarangKeluarController::class, 'store'])->name('keluar.store');
    Route::delete('/keluar/{barangKeluar}', [BarangKeluarController::class, 'destroy'])->name('keluar.destroy');

    Route::get('/laporan', [LaporanStokController::class, 'index'])->name('laporan');
    Route::get('/laporan/pdf', [LaporanStokController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanStokController::class, 'exportExcel'])->name('laporan.excel');
});


// Kelola Keuangan
Route::prefix('admin/kelola_keuangan')->name('admin.kelola_keuangan.')->middleware('role:supervisor,leader_shift,admin')->group(function () {
    Route::get('/dashboard', [KeuanganController::class, 'dashboard'])->name('dashboard');

    // Sales Harian / Pendapatan
    Route::get('/sales', [KeuanganController::class, 'penjualanIndex'])->name('sales.index');
    Route::get('/sales/create', [KeuanganController::class, 'salesCreate'])->name('sales.create');
    Route::post('/sales', [KeuanganController::class, 'salesStore'])->name('sales.store');
    Route::get('/sales/{sales}', [KeuanganController::class, 'salesShow'])->name('sales.show');
    Route::delete('/sales/{sales}', [KeuanganController::class, 'salesDestroy'])->name('sales.destroy');

    // Cashflow
    Route::get('/cashflow', [KeuanganController::class, 'cashflowIndex'])->name('cashflow.index');
    Route::post('/cashflow', [KeuanganController::class, 'cashflowStore'])->name('cashflow.store');

    // Laporan Kas
    Route::get('/laporan', [KeuanganController::class, 'laporanIndex'])->name('laporan');
    Route::get('/laporan/pdf', [KeuanganController::class, 'laporanExportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [KeuanganController::class, 'laporanExportExcel'])->name('laporan.excel');
});

use App\Http\Controllers\MidtransWebhookController;
Route::post('/midtrans/iris-webhook', [MidtransWebhookController::class, 'handleIris'])->name('midtrans.iris_webhook');
Route::post('/midtrans/simulate-webhook', [MidtransWebhookController::class, 'simulateWebhook'])->name('midtrans.simulate_webhook');

