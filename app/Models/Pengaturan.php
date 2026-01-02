<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaturan extends Model
{
    use HasFactory;

    /**
     * Nama tabel eksplisit
     */
    protected $table = 'pengaturans';

    /**
     * Kolom yang boleh diisi (Fillable)
     * Ditambahkan 'label' dan 'type' sesuai migrasi terbaru
     */
    protected $fillable = [
        'key', 
        'label', 
        'value', 
        
    ];

    /**
     * HELPER: Ambil nilai pengaturan berdasarkan key.
     * Penggunaan di Controller/View: 
     * $jamMasuk = \App\Models\Pengaturan::getVal('jam_masuk', '08:00');
     */
    public static function getVal($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}