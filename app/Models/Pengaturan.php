<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    /**
     * Nama tabel eksplisit (Best Practice)
     */
    protected $table = 'pengaturans';

    /**
     * Kolom yang boleh diisi melalui form/updateOrCreate
     */
    protected $fillable = [
        'key', 
        'value'
    ];

    /**
     * HELPER: Ambil nilai pengaturan berdasarkan key.
     * Penggunaan: 
     * $jamMasuk = \App\Models\Pengaturan::getVal('jam_masuk', '08:00');
     */
    public static function getVal($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}