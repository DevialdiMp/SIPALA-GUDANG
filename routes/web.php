<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ManagementPinController;
use App\Http\Controllers\Dashboard\DashboardAdminController;
use App\Http\Controllers\MasterData\DataTeknisiController;
use App\Http\Controllers\MasterData\DataAlatController;
use App\Http\Controllers\Transaksi\PeminjamanAlatController;
use App\Http\Controllers\Transaksi\PengembalianAlatController;
use App\Http\Controllers\Riwayat\RiwayatAlatController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardAdminController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/verifikasi-pin', [ManagementPinController::class, 'show'])
        ->name('pin.form');

    Route::post('/verifikasi-pin', [ManagementPinController::class, 'verify'])
        ->middleware('throttle:10,1')
        ->name('pin.verify');

    Route::post('/keluar-master-data/{feature}', [ManagementPinController::class, 'leave'])
        ->name('pin.leave');

    Route::prefix('masterdata')
        ->name('masterdata.')
        ->middleware('management.pin:teknisi')
        ->group(function () {

            Route::resource('teknisi', DataTeknisiController::class);
        });

    Route::prefix('masterdata')
        ->name('masterdata.')
        ->middleware('management.pin:alat')
        ->group(function () {

            Route::resource('alat', DataAlatController::class);
        });

    Route::prefix('transaksi')
        ->name('transaksi.')
        ->group(function () {

            Route::resource('peminjaman', PeminjamanAlatController::class)
                ->only(['index', 'create', 'store', 'show']);

            Route::resource('pengembalian', PengembalianAlatController::class)
                ->only(['index', 'create', 'store', 'show']);
        });

    Route::prefix('riwayat')
        ->name('riwayat.')
        ->group(function () {
            Route::resource('riwayat-transaksi', RiwayatAlatController::class)
                ->only(['index', 'show']);
        });
});
