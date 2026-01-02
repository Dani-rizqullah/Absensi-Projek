<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengaturan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Administrator Utama
        User::create([
            'name' => 'Administrator DSM',
            'email' => 'admin@dsm.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'no_wa' => '6282211431087', // Format internasional untuk Nudge WA
            'divisi' => null,
            'poin' => 0,
        ]);

        // 2. Buat Contoh Akun Karyawan (Untuk Testing Reward & Nudge)
        User::create([
            'name' => 'Karyawan Demo',
            'email' => 'karyawan@dsm.com',
            'password' => Hash::make('karyawan123'),
            'role' => 'karyawan',
            'no_wa' => '6282273116245', // Gunakan nomor aktif untuk tes kirim pesan
            'divisi' => 'Web Developer',
            'poin' => 100, // Saldo awal poin sebagai apresiasi bergabung
        ]);

        User::create([
            'name' => 'minda',
            'email' => 'minda@dsm.com',
            'password' => Hash::make('karyawan123'),
            'role' => 'karyawan',
            'no_wa' => '', // Gunakan nomor aktif untuk tes kirim pesan
            'divisi' => 'Web Developer',
            'poin' => 100, // Saldo awal poin sebagai apresiasi bergabung
        ]);

        User::create([
            'name' => 'rina',
            'email' => 'rina@dsm.com',
            'password' => Hash::make('karyawan123'),
            'role' => 'karyawan',
            'no_wa' => '', // Gunakan nomor aktif untuk tes kirim pesan
            'divisi' => 'Web Developer',
            'poin' => 100, // Saldo awal poin sebagai apresiasi bergabung
        ]);

        // 3. Set Jam Masuk Default (Acuan keterlambatan)
        Pengaturan::create([
            'key' => 'jam_masuk',
            'value' => '08:00',
        ]);
    }
}