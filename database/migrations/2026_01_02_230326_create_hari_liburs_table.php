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
    Schema::create('hari_liburs', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal')->unique(); // Tanggal libur (Y-m-d)
        $table->string('keterangan');      // Misal: "Tahun Baru", "Cuti Bersama"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hari_liburs');
    }
};
