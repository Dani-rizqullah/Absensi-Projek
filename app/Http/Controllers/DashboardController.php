<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use App\Models\HariLibur;
use App\Models\Pengaturan;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. REDIRECTION ROLE
        if ($user->isAdmin()) {
            return redirect()->route('admin.monitoring');
        }

        if ($user->isMentor()) {
            return redirect()->route('mentor.dashboard');
        }

        // --- LOGIKA KARYAWAN ---

        $month = intval($request->input('month', date('m')));
        $year = intval($request->input('year', date('Y')));
        $dateContext = Carbon::createFromDate($year, $month, 1);
        $month = $dateContext->month;
        $year = $dateContext->year;

        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // 2. Cek Data Absen Hari Ini
        $absenHariIni = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        // 3. Status Hari Libur (Hari Ini)
        $hariLibur = HariLibur::where('tanggal', $today)->first();

        // 4. Jendela Waktu & Status Operasional
        $statusAbsen = [
            'is_libur' => (bool)$hariLibur,
            'keterangan_libur' => $hariLibur ? $hariLibur->keterangan : null,
            'boleh_absen_masuk' => $now->between(Carbon::parse(Pengaturan::getVal('buffer_masuk', '07:30')), Carbon::parse(Pengaturan::getVal('batas_tutup_masuk', '10:00'))),
            'boleh_absen_keluar' => $now->between(Carbon::parse(Pengaturan::getVal('buffer_keluar', '16:45')), Carbon::parse(Pengaturan::getVal('batas_tutup_keluar', '22:00'))),
            'pesan_masuk' => "Sinyal masuk tersedia",
            'pesan_keluar' => "Sinyal keluar tersedia"
        ];

        // 5. Riwayat Absen & Hari Libur Bulan Ini (Key as String Y-m-d)
        $riwayatAbsen = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get()
            ->mapWithKeys(function ($item) {
                $key = ($item->tanggal instanceof \Carbon\Carbon) 
                       ? $item->tanggal->format('Y-m-d') 
                       : date('Y-m-d', strtotime($item->tanggal));
                return [$key => $item];
            });

        $listLiburBulanIni = HariLibur::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get()
            ->mapWithKeys(function ($item) {
                $key = ($item->tanggal instanceof \Carbon\Carbon) 
                       ? $item->tanggal->format('Y-m-d') 
                       : date('Y-m-d', strtotime($item->tanggal));
                return [$key => $item];
            });

        // 6. Data Tugas untuk Kalender (Mengambil semua yang beririsan dengan bulan terpilih)
        $tugasKalender = $user->tugas()
            ->where(function($q) use ($year, $month) {
                $q->whereMonth('tgl_mulai', $month)->whereYear('tgl_mulai', $year)
                  ->orWhereMonth('tgl_selesai', $month)->whereYear('tgl_selesai', $year);
            })->get();

        // 7. PERBAIKAN: Tugas Ongoing (Sidebar Kanan)
        // Hanya yang: Status Belum Selesai DAN Tanggal Sekarang berada di dalam rentang tugas
        $tugasOngoing = $user->tugas()
            ->wherePivot('status', '!=', 'selesai')
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today)
            ->latest()
            ->get();

        return view('karyawan.dashboard', compact(
            'absenHariIni', 
            'riwayatAbsen', 
            'listLiburBulanIni', 
            'month', 
            'year',
            'statusAbsen',
            'tugasKalender',
            'tugasOngoing'
        ));
    }
}