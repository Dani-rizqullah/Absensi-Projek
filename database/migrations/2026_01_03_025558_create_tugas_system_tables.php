<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat sistem tugas.
     */
    public function up(): void
    {
        // 1. Tabel Induk Tugas (Instruksi dari Mentor)
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke ID Mentor (User dengan role mentor)
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('divisi'); 
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->timestamps();
        });

        // 2. Tabel Penghubung (Data Pengumpulan & Status per Karyawan)
        Schema::create('tugas_karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Status pengerjaan: pending, ongoing, dikumpulkan
            $table->string('status')->default('pending'); 
            
            // Bukti Pengumpulan Kerja
            $table->string('file_hasil')->nullable(); // Nama file yang diunggah
            $table->text('link_tautan')->nullable();  // Link tambahan (G-Drive/Github)
            $table->text('pesan_karyawan')->nullable();
            $table->dateTime('tgl_pengumpulan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (Hapus tabel jika rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_karyawan');
        Schema::dropIfExists('tugas');
    }
};