<?php

use App\Http\Controllers\AnomalyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'bendahara' => redirect()->route('bendahara.dashboard'),
            default => redirect()->route('warga.dashboard'),
        };
    })->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/kepala-keluarga', [WargaController::class, 'index'])->name('kepala-keluarga.index');
        Route::post('/kepala-keluarga', [WargaController::class, 'store'])->name('kepala-keluarga.store');
        Route::put('/kepala-keluarga/{warga}', [WargaController::class, 'update'])->name('kepala-keluarga.update');
        Route::delete('/kepala-keluarga/{warga}', [WargaController::class, 'destroy'])->name('kepala-keluarga.destroy');

        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    });

    Route::middleware('role:admin,bendahara,warga')->group(function () {
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });

    Route::middleware('role:admin,bendahara')->group(function () {
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

        Route::get('/anomalies', [AnomalyController::class, 'index'])->name('anomalies.index');
        Route::get('/anomalies/{transaction}', [AnomalyController::class, 'show'])->name('anomalies.show');
        Route::put('/anomalies/{transaction}/audit-status', [AnomalyController::class, 'updateAuditStatus'])->name('anomalies.updateAuditStatus');
    });

    Route::middleware('role:bendahara')->prefix('bendahara')->group(function () {
        Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('bendahara.dashboard');
    });

    Route::middleware('role:warga')->prefix('warga')->group(function () {
        Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');
    });
});
