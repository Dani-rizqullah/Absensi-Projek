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

        // Daftar Divisi yang tersedia
        $divisiList = ['Jurnalis', 'Web Developer', 'UI/UX Design', 'Videographer/Editor'];

        // 2. Buat Akun Mentor (1 per Divisi)
        foreach ($divisiList as $index => $div) {
            User::create([
                'name' => 'Mentor ' . $div,
                'email' => 'mentor.' . strtolower(str_replace(['/', ' '], '', $div)) . '@dsm.com',
                'password' => Hash::make('mentor123'),
                'role' => 'mentor',
                'no_wa' => '62812345678' . $index,
                'divisi' => $div,
                'poin' => 0,
            ]);

            // 3. Buat Akun Karyawan (2 per Divisi)
            for ($i = 1; $i <= 2; $i++) {
                User::create([
                    'name' => 'Staff ' . $div . ' ' . $i,
                    'email' => 'staff' . $i . '.' . strtolower(str_replace(['/', ' '], '', $div)) . '@dsm.com',
                    'password' => Hash::make('karyawan123'),
                    'role' => 'karyawan',
                    'no_wa' => '62857123456' . $index . $i,
                    'divisi' => $div,
                    'poin' => 100,
                ]);
            }
        }

        // 4. Konfigurasi Sistem (Pengaturans)
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