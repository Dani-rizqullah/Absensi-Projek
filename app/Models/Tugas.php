<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'mentor_id',
        'judul',
        'deskripsi',
        'divisi',
        'tgl_mulai',
        'tgl_selesai'
    ];

    /**
     * Casting otomatis kolom ke objek Carbon/Datetime
     */
    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    // Relasi: Tugas ini dibuat oleh seorang Mentor
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    // Relasi: Satu tugas bisa dimiliki banyak karyawan (Many-to-Many)
    public function karyawans()
    {
        return $this->belongsToMany(User::class, 'tugas_karyawan', 'tugas_id', 'user_id')
            // Tambahkan 'alasan_tolak' di sini
            ->withPivot('status', 'file_hasil', 'link_tautan', 'pesan_karyawan', 'alasan_tolak', 'tgl_pengumpulan')
            ->withTimestamps();
    }
}