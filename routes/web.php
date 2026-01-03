<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\TugasController; // Ini TugasController utama (Mentor/Karyawan)
// Aliasing untuk Admin Tugas Controller agar tidak bentrok
use App\Http\Controllers\Admin\TugasController as AdminTugasController; 

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * 1. DASHBOARD SENTRAL
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * 2. ALUR KERJA KARYAWAN (Presensi)
     */
    Route::prefix('absen')->name('absen.')->group(function () {
        Route::post('/masuk', [AbsensiController::class, 'storeMasuk'])->name('masuk');
        Route::post('/keluar', [AbsensiController::class, 'storeKeluar'])->name('keluar');
        Route::post('/backdate', [AbsensiController::class, 'storeBackdate'])->name('backdate');
    });

    /**
     * 3. FITUR TUGAS KARYAWAN (Mission Hub)
     */
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [TugasController::class, 'indexKaryawan'])->name('index');
        Route::post('/kumpul', [TugasController::class, 'kumpulTugas'])->name('kumpul');
    });

    /**
     * 4. AREA ADMIN (The Command Center)
     */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/monitoring', [AbsensiController::class, 'indexAdmin'])->name('monitoring');
        Route::get('/dashboard', [AbsensiController::class, 'indexAdmin'])->name('dashboard');

        // Monitoring Tugas oleh Admin
        Route::get('/monitoring-tugas', [AdminTugasController::class, 'index'])->name('tugas.index');
        Route::delete('/monitoring-tugas/{id}', [AdminTugasController::class, 'destroy'])->name('tugas.destroy');

        Route::get('/laporan', [AbsensiController::class, 'laporan'])->name('laporan');
        Route::post('/approve/{id}', [AbsensiController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [AbsensiController::class, 'reject'])->name('reject');

        Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('/libur/store', [PengaturanController::class, 'storeLibur'])->name('libur.store');
        Route::delete('/libur/{id}', [PengaturanController::class, 'destroyLibur'])->name('libur.destroy');
    });

    /**
     * 5. AREA MENTOR (The Operation Room)
     */
    Route::middleware(['mentor'])->prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/dashboard', [MentorController::class, 'index'])->name('dashboard');
        Route::get('/personnel', [MentorController::class, 'personnel'])->name('personnel');
        Route::get('/karyawan/{id}', [MentorController::class, 'showKaryawan'])->name('show_karyawan');

        // MANAJEMEN TUGAS OLEH MENTOR
        Route::post('/tugas/simpan', [TugasController::class, 'store'])->name('tugas.store');
        Route::post('/tugas/update/{id}', [TugasController::class, 'update'])->name('tugas.update');
        
        // FITUR HAPUS MISI (Hanya Mentor pembuat atau Admin)
        Route::delete('/tugas/destroy/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');

        // APPROVAL & REJECT LAPORAN KRU
        Route::post('/tugas/selesai/{tugasId}/{userId}', [TugasController::class, 'tandaiSelesai'])->name('tugas.selesai');
        Route::post('/tugas/tolak/{tugasId}/{userId}', [TugasController::class, 'tolakLaporan'])->name('tugas.tolak');
    });

    /**
     * 6. PROFILE SELF-SERVICE
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';