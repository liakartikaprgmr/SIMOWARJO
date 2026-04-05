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

//route presensi
Route::post('/presensi/upload', [PresensiController::class, 'upload'])->name('presensi.upload');
//Route::post('/presensi/upload', function(Request $request) {
    // Forward ke FastAPI
    //$response = Http::post('http://127.0.0.1:8001/attendance', [
        //'email' => $request->email,
        //'image' => $request->image
    //]);
    //return $response->json();
//});
