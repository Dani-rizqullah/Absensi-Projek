<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            // Laporan Kerja (Wajib diisi saat Absen Keluar / Pengajuan Lupa Absen)
            $table->text('kegiatan_harian')->nullable();
            $table->text('progres_perubahan')->nullable(); 
            $table->string('foto_bukti')->nullable(); // Foto kerja atau surat sakit/izin

            /**
             * STATUS: Menggunakan string agar tidak ada batasan kata (flexibel).
             * Nullable berarti secara default database tidak memberikan label apapun.
             * Label "Tanpa Keterangan" akan muncul lewat logika Code jika data ini kosong.
             */
            $table->string('status')->nullable(); 
            
            // Status Approval untuk pengajuan (Lupa, Sakit, Izin)
            // 'Auto' untuk absen harian normal, 'Pending' untuk pengajuan yang butuh approve admin.
            $table->string('approval_status')->default('Auto');
            
            // Kolom Keterangan Tambahan
            $table->text('alasan_lupa_absen')->nullable(); // Alasan kenapa tidak absen tepat waktu
            
            // Sistem Poin Harian
            $table->integer('poin_didapat')->default(0); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};