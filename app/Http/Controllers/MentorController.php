<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MentorController extends Controller
{
    /**
     * Dashboard Utama Mentor (Operasional Harian)
     */
    public function index(Request $request)
    {
        $mentor = Auth::user();
        $today = Carbon::today()->toDateString();

        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        $karyawanDivisi = User::where('role', 'karyawan')
                            ->where('divisi', $mentor->divisi)
                            ->with(['absensis' => function($q) use ($today) {
                                $q->where('tanggal', $today);
                            }])
                            ->get();

        $totalPersonil = $karyawanDivisi->count();
        $hadirHariIni = $karyawanDivisi->filter(function($u) {
            return $u->absensis->isNotEmpty();
        })->count();

        $daftarTugas = Tugas::where('mentor_id', $mentor->id)
                            ->whereMonth('tgl_selesai', $selectedMonth)
                            ->whereYear('tgl_selesai', $selectedYear)
                            ->with(['karyawans' => function($q) {
                                $q->orderByPivot('tgl_pengumpulan', 'desc');
                            }])
                            ->latest()
                            ->paginate(10)
                            ->withQueryString();

        return view('mentor.dashboard', compact(
            'mentor', 
            'karyawanDivisi', 
            'totalPersonil', 
            'hadirHariIni',
            'daftarTugas',
            'selectedMonth',
            'selectedYear'
        ));
    }

    /**
     * HALAMAN BARU: Daftar Seluruh Personel (Sesuai Navigasi)
     * Untuk diakses melalui menu "Personnel" di Navbar
     */
    public function personnel()
    {
        $mentor = Auth::user();

        // Ambil semua karyawan di divisi yang sama untuk ditampilkan sebagai daftar (Index)
        $karyawans = User::where('divisi', $mentor->divisi)
                        ->where('role', 'karyawan')
                        ->orderBy('name', 'asc')
                        ->get();

        return view('mentor.personnel', compact('karyawans'));
    }

    /**
     * Detail Progres Karyawan (Rapor Intelijen)
     */
    public function showKaryawan($id)
    {
        $mentor = Auth::user();

        $user = User::where('divisi', $mentor->divisi)
                    ->where('role', 'karyawan')
                    ->with(['tugas' => function($q) {
                        $q->orderBy('tgl_selesai', 'desc');
                    }])
                    ->findOrFail($id);

        $totalMisi = $user->tugas->count();
        $misiSelesai = $user->tugas->where('pivot.status', 'selesai')->count();
        
        $stats = [
            'total' => $totalMisi,
            'selesai' => $misiSelesai,
            'proses' => $user->tugas->whereIn('pivot.status', ['pending', 'dikumpulkan'])->count(),
            'success_rate' => $totalMisi > 0 ? round(($misiSelesai / $totalMisi) * 100) : 0
        ];
        
        $riwayatAbsensi = Absensi::where('user_id', $user->id)
                                ->latest()
                                ->limit(30)
                                ->get();

        return view('mentor.show_karyawan', compact('user', 'riwayatAbsensi', 'stats'));
    }
}