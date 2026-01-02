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
            'no_wa' => '6282211431087',
            'divisi' => null,
            'poin' => 0,
        ]);

        // 2. Buat Contoh Akun Karyawan
        $users = [
            [
                'name' => 'Karyawan Demo',
                'email' => 'karyawan@dsm.com',
                'password' => Hash::make('karyawan123'),
                'role' => 'karyawan',
                'no_wa' => '6282273116245',
                'divisi' => 'Web Developer',
                'poin' => 100,
            ],
            [
                'name' => 'Minda',
                'email' => 'minda@dsm.com',
                'password' => Hash::make('karyawan123'),
                'role' => 'karyawan',
                'no_wa' => '',
                'divisi' => 'Web Developer',
                'poin' => 100,
            ],
            [
                'name' => 'Rina',
                'email' => 'rina@dsm.com',
                'password' => Hash::make('karyawan123'),
                'role' => 'karyawan',
                'no_wa' => '',
                'divisi' => 'Web Developer',
                'poin' => 100,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // 3. Konfigurasi Sistem (Pengaturans)
        // Disesuaikan dengan struktur baru: key, label, value, type

        $settings = [
            ['key' => 'jam_masuk', 'label' => 'Jam Masuk Utama', 'value' => '08:00'],
            ['key' => 'jam_pulang', 'label' => 'Jam Pulang Utama', 'value' => '17:00'],
            ['key' => 'buffer_masuk', 'label' => 'Jendela Buka Masuk', 'value' => '07:30'],
            ['key' => 'batas_tutup_masuk', 'label' => 'Jendela Tutup Masuk', 'value' => '10:00'],
            ['key' => 'buffer_keluar', 'label' => 'Jendela Buka Pulang', 'value' => '16:45'],
            ['key' => 'batas_tutup_keluar', 'label' => 'Sinyal Operasional Berakhir', 'value' => '22:00'],
        ];

        foreach ($settings as $setting) {
            Pengaturan::create($setting);
        }
    }
}
