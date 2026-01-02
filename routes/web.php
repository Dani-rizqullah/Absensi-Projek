<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// SEMUA ROUTE DI BAWAH INI WAJIB LOGIN
Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * 1. DASHBOARD SENTRAL (The Traffic Controller)
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * 2. ALUR KERJA KARYAWAN (The Productivity Cycle)
     */
    Route::prefix('absen')->name('absen.')->group(function () {
        Route::post('/masuk', [AbsensiController::class, 'storeMasuk'])->name('masuk');
        Route::post('/keluar', [AbsensiController::class, 'storeKeluar'])->name('keluar');
        Route::post('/backdate', [AbsensiController::class, 'storeBackdate'])->name('backdate');
    });

    /**
     * 3. AREA ADMIN (The Command Center)
     * Diproteksi oleh middleware 'admin'
     */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Monitoring Real-time Hari Ini
        Route::get('/monitoring', [AbsensiController::class, 'indexAdmin'])->name('monitoring');
        
        // Fitur Laporan Bulanan (Reporting Center)
        Route::get('/laporan', [AbsensiController::class, 'laporan'])->name('laporan');
        
        // Approval System
        Route::post('/approve/{id}', [AbsensiController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [AbsensiController::class, 'reject'])->name('reject');
        
        /**
         * PUSAT OTORITAS PERSONEL
         */
        Route::resource('users', UserController::class)->only([
            'index', 'update', 'destroy'
        ]);

        /**
         * GLOBAL CONFIG & HOLIDAY MANAGEMENT
         */
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        // Gunakan PUT agar sesuai dengan @method('PUT') di view
        Route::put('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
        
        // Route Baru untuk Hari Libur
        Route::post('/libur/store', [PengaturanController::class, 'storeLibur'])->name('libur.store');
        Route::delete('/libur/{id}', [PengaturanController::class, 'destroyLibur'])->name('libur.destroy');
    });

    /**
     * 4. PROFILE SELF-SERVICE
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';