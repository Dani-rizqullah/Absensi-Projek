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
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_wa',
        'role',          // admin, mentor, atau karyawan
        'divisi',
        'poin',
        'foto_profile',
    ];

    /**
     * Konstanta untuk mempermudah pemanggilan role di seluruh aplikasi.
     * Ini mencegah kesalahan pengetikan (typo).
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_MENTOR = 'mentor';
    const ROLE_KARYAWAN = 'karyawan';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'poin' => 'integer',
        ];
    }

    // ==========================================
    // FUNGSI PENGECEKAN ROLE (Helper)
    // ==========================================

    /**
     * Cek apakah user adalah Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Cek apakah user adalah Mentor.
     */
    public function isMentor(): bool
    {
        return $this->role === self::ROLE_MENTOR;
    }

    /**
     * Cek apakah user adalah Karyawan.
     */
    public function isKaryawan(): bool
    {
        return $this->role === self::ROLE_KARYAWAN;
    }

    // ==========================================
    // RELASI
    // ==========================================

    /**
     * RELASI: Satu User memiliki banyak data Absensi.
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * RELASI UNTUK FITUR MENTOR (Mendatang):
     * Jika user adalah Mentor, dia memiliki banyak tugas yang dibuat.
     */
    public function tugasDibuat()
    {
        return $this->hasMany(Tugas::class, 'mentor_id');
    }

    /**
     * RELASI UNTUK FITUR TUGAS (Mendatang):
     * User (Karyawan) bisa memiliki banyak tugas dari mentor.
     */
    public function tugas()
    {
        return $this->belongsToMany(Tugas::class, 'tugas_karyawan', 'user_id', 'tugas_id')
            ->withPivot('status', 'file_hasil', 'link_tautan', 'pesan_karyawan', 'tgl_pengumpulan')
            ->withTimestamps();
    }
}
