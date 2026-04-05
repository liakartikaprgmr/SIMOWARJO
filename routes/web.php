<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\DashboardKaryawanController;
use App\Http\Controllers\PresensiController;


Route::get('/', function () {
    return view('welcome');
});

//Route Proses Autentication
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route untuk admin
Route::get('/admin/dashboard', [DasboardAdminController::class, 'dashboard'])->name('admin.dashboard');

// Route untuk karyawan
Route::get('/karyawan/dashboard', [DashboardKaryawanController::class, 'dashboard'])->name('karyawan.dashboard');
Route::get('/karyawan/presensi', [PresensiController::class, 'index'])->name('karyawan.presensi');
Route::post('/presensi/upload', [PresensiController::class, 'upload'])->name('presensi.upload');
//Route::post('/presensi/upload', function(Request $request) {
    // Forward ke FastAPI
    //$response = Http::post('http://127.0.0.1:8001/attendance', [
        //'email' => $request->email,
        //'image' => $request->image
    //]);
    //return $response->json();
//});
