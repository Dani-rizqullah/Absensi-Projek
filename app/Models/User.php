<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignable).
     * Pastikan kolom baru dari migrasi Anda terdaftar di sini.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_wa',         // Penting untuk fitur Nudge WA
        'role',          // admin atau karyawan
        'divisi',        // Penempatan divisi
        'poin',          // Saldo poin kedisiplinan
        'foto_profile',  // Link foto profil
    ];

    /**
     * Atribut yang disembunyikan saat data diubah menjadi array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data agar Laravel memperlakukannya dengan benar.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'poin' => 'integer', // Pastikan poin selalu berupa angka
        ];
    }

    /**
     * RELASI: Satu User memiliki banyak data Absensi.
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}