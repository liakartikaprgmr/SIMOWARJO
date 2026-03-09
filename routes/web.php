<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\DashboardKaryawanController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::get('/admin/dashboard', [DasboardAdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/karyawan/dashboard', [DashboardKaryawanController::class, 'dashboard'])
    ->name('karyawan.dashboard');
