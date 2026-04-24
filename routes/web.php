<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\DashboardKaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KaryawanController;


Route::get('/', function () {
    return view('welcome');
});

// Route Proses Autentication
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// Route untuk admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DasboardAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelola_karyawan', [KaryawanController::class, 'kelola_karyawan'])->name('kelola_karyawan');
    Route::get('/tambah_karyawan', [KaryawanController::class, 'tambah_karyawan'])->name('tambah_karyawan');
    Route::post('/tambah_karyawan', [KaryawanController::class, 'store_karyawan'])->name('store_karyawan');
    Route::get('/edit_karyawan/{id}', [KaryawanController::class, 'edit_karyawan'])->name('edit_karyawan');
    Route::post('/update_karyawan/{id}', [KaryawanController::class, 'update_karyawan'])->name('update_karyawan');
    Route::delete('/delete_karyawan/{id}', [KaryawanController::class, 'delete_karyawan'])->name('delete_karyawan');
});

// Route untuk karyawan
Route::prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [DashboardKaryawanController::class, 'dashboard'])->name('dashboard');
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
});

Route::get('/known_faces/{filename}', function ($filename) {
    $path = base_path('ai_absensi/known_faces/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

// route untuk presensi
Route::post('/presensi/upload', [PresensiController::class, 'upload'])->name('presensi.upload');

use App\Http\Controllers\PenggajianController;

// Rute Tambahan untuk Admin (Persetujuan Izin & Penggajian)
Route::prefix('admin')->name('admin.')->group(function () {
    // Perizinan (Menu Mandiri)
    Route::get('/perizinan/persetujuan', [\App\Http\Controllers\PerizinanController::class, 'index'])->name('perizinan.index');
    Route::post('/perizinan/persetujuan/{id}', [\App\Http\Controllers\PerizinanController::class, 'updateStatus'])->name('perizinan.update_status');

    // Geolokasi
    Route::get('/geolokasi', [\App\Http\Controllers\GeolokasiController::class, 'index'])->name('geolokasi.index');
    Route::post('/geolokasi', [\App\Http\Controllers\GeolokasiController::class, 'update'])->name('geolokasi.update');

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
    Route::get('/izin', [PresensiController::class, 'createIzin'])->name('izin');
    Route::post('/izin', [PresensiController::class, 'storeIzin'])->name('izin.store');
    
    Route::get('/sick-leave', [PresensiController::class, 'createSakit'])->name('sick_leave');
});

use App\Http\Controllers\MidtransWebhookController;
Route::post('/midtrans/iris-webhook', [MidtransWebhookController::class, 'handleIris'])->name('midtrans.iris_webhook');
Route::post('/midtrans/simulate-webhook', [MidtransWebhookController::class, 'simulateWebhook'])->name('midtrans.simulate_webhook');
