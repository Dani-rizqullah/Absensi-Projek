<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Absensi extends Model
{
    /**
     * Kolom yang bisa diisi secara massal.
     * Pastikan foto_bukti digunakan untuk semua jenis unggahan gambar (Laporan/Sakit/Izin)
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'kegiatan_harian',
        'progres_perubahan',
        'foto_bukti',      // Digunakan serbaguna untuk bukti kerja/surat sakit/izin
        'status',          // Hadir, Terlambat, Sakit, Izin
        'approval_status', // Auto, Pending, Approved, Rejected
        'alasan_lupa_absen',
        'poin_didapat'
    ];

    /**
     * Casting tipe data.
     * Menggunakan format 'H:i' agar saat dipanggil di Blade/AlpineJS lebih bersih.
     */
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
        'poin_didapat' => 'integer',
    ];

    /**
     * RELASI: Setiap data absensi dimiliki oleh satu User (Karyawan).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SCOPE: Mengambil data yang butuh persetujuan admin.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('approval_status', 'Pending');
    }

    /**
     * SCOPE: Mengambil absensi hari ini saja.
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->where('tanggal', now()->toDateString());
    }

    /**
     * HELPER: Menentukan warna status untuk UI Kalender/Admin
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Selesai', 'Hadir' => 'emerald',
            'Terlambat'       => 'amber',
            'Sakit', 'Izin'    => 'blue',
            default            => 'rose',
        };
    }
}