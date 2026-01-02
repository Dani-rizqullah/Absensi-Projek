<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil data jam, jika belum ada di DB kasih default 08:00 dan 17:00
        $jam_masuk = Pengaturan::getVal('jam_masuk', '08:00');
        $jam_pulang = Pengaturan::getVal('jam_pulang', '17:00');
        
        return view('admin.pengaturan', compact('jam_masuk', 'jam_pulang'));
    }

    public function update(Request $request)
    {
        // Langsung simpan dua data sekaligus
        Pengaturan::updateOrCreate(['key' => 'jam_masuk'], ['value' => $request->jam_masuk]);
        Pengaturan::updateOrCreate(['key' => 'jam_pulang'], ['value' => $request->jam_pulang]);

        return back()->with('success', 'Sistem berhasil diperbarui!');
    }
}