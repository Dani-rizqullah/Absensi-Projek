<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // 1. Ambil daftar divisi untuk filter dropdown (opsional)
        $daftarDivisi = User::whereNotNull('divisi')
            ->where('divisi', '!=', '')
            ->distinct()
            ->pluck('divisi');

        // 2. Query data tugas dengan relasi dan perhitungan progres
        $tugasQuery = Tugas::query()
            ->with('mentor:id,name') 
            ->withCount([
                'karyawans as total_unit', 
                'karyawans as unit_selesai' => function ($query) {
                    $query->where('tugas_karyawan.status', 'selesai');
                }
            ])
            ->when($search, function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('tgl_selesai', 'asc');

        // 3. Eksekusi query dan KELOMPOKKAN berdasarkan kolom 'divisi'
        // Variabel ini yang dicari oleh file Blade Anda
        $tugasPerDivisi = $tugasQuery->get()->groupBy('divisi');

        // 4. Kirim variabel ke view
        return view('admin.monitoring_tugas', compact('tugasPerDivisi', 'daftarDivisi'));
    }
}