<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SatpamController;
use App\Http\Controllers\AuthSatpamController;

Route::prefix('filament')->middleware('role:admin')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

// Rute autentikasi untuk satpam
Route::get('/satpam/login', [AuthSatpamController::class, 'showLoginForm'])->name('satpam.login');
Route::post('/satpam/login', [AuthSatpamController::class, 'login'])->name('satpam.login.submit');

Route::prefix('satpam')->group(function () {
    Route::get('/', function () {
        return view('satpam.dashboard');
    })->middleware('auth');
    Route::get('/dashboard', function () {
        return view('satpam.dashboard');
    })->name('satpam.dashboard')->middleware('auth');
    Route::get('/tambah-tamu', function () {
        return view('satpam.tambah-tamu');
    })->middleware('auth');
    Route::post('/tambah-tamu', [SatpamController::class, 'tambahTamu'])->name('satpam.tambah-tamu')->middleware('auth');
    Route::get('/daftar-tamu', [SatpamController::class, 'daftarTamu'])->name('satpam.daftar-tamu')->middleware('auth');
    
    Route::get('/export-tamu/{type}', [SatpamController::class, 'exportTamu'])->name('satpam.export-tamu')->middleware('auth');
    Route::get('/jadwal-satpam', function () {
        $jadwals = App\Models\PenjadwalanSatpam::all();
        return view('satpam.jadwal-satpam', compact('jadwals'));
    })->name('satpam.jadwal-satpam')->middleware('auth');
    
    Route::post('/logout-tamu/{id}', [SatpamController::class, 'logoutTamu'])->name('satpam.logout-tamu')->middleware('auth');
    Route::post('/edit-tamu/{id}', [SatpamController::class, 'editTamu'])->name('satpam.edit-tamu')->middleware('auth');
    Route::post('/logout', [AuthSatpamController::class, 'logout'])->name('logout')->middleware('auth');
});
