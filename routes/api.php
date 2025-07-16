<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatpamController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/new-guests', [SatpamController::class, 'getNewGuests']);
    Route::get('/jadwal-satpam', [SatpamController::class, 'getJadwalSatpam']);
});
