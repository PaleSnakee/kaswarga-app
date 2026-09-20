<?php

use App\Http\Controllers\AnomalyController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WargaController::class, 'dashboard'])->name('dashboard');
Route::get('/kepala-keluarga', [WargaController::class, 'index'])->name('kepala-keluarga.index');
Route::post('/kepala-keluarga', [WargaController::class, 'store'])->name('kepala-keluarga.store');
Route::put('/kepala-keluarga/{warga}', [WargaController::class, 'update'])->name('kepala-keluarga.update');
Route::delete('/kepala-keluarga/{warga}', [WargaController::class, 'destroy'])->name('kepala-keluarga.destroy');

Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::get('/anomalies', [AnomalyController::class, 'index'])->name('anomalies.index');
Route::get('/anomalies/{transaction}', [AnomalyController::class, 'show'])->name('anomalies.show');
Route::put('/anomalies/{transaction}/audit-status', [AnomalyController::class, 'updateAuditStatus'])->name('anomalies.updateAuditStatus');
