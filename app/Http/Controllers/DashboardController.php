<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use App\Models\HariLibur;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return app(AbsensiController::class)->indexAdmin($request);
        }

        // 1. Logika Kalender Riwayat
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

        // 3. CEK STATUS HARI LIBUR
        $hariLibur = HariLibur::where('tanggal', $today)->first();

        // 4. CEK JENDELA WAKTU (Logika Sederhana: Semua Berbasis Waktu)
        // Ambil titik waktu langsung dari database tanpa hitung menit lagi
        $waktuMulaiMasuk    = Carbon::parse(Pengaturan::getVal('buffer_masuk', '07:30'));
        $waktuSelesaiMasuk  = Carbon::parse(Pengaturan::getVal('batas_tutup_masuk', '10:00'));
        $waktuMulaiKeluar   = Carbon::parse(Pengaturan::getVal('buffer_keluar', '16:45'));
        $waktuSelesaiKeluar = Carbon::parse(Pengaturan::getVal('batas_tutup_keluar', '22:00'));

        // Menentukan status jendela untuk dikirim ke View
        $statusAbsen = [
            'is_libur' => (bool)$hariLibur,
            'keterangan_libur' => $hariLibur ? $hariLibur->keterangan : null,
            
            // Logika Masuk: Diantara mulai s/d selesai
            'boleh_absen_masuk' => $now->between($waktuMulaiMasuk, $waktuSelesaiMasuk),
            
            // Logika Keluar: Diantara mulai s/d selesai
            'boleh_absen_keluar' => $now->between($waktuMulaiKeluar, $waktuSelesaiKeluar),
            
            'pesan_masuk' => $now->lt($waktuMulaiMasuk) 
                ? "Otorisasi dibuka pukul " . $waktuMulaiMasuk->format('H:i') 
                : ($now->gt($waktuSelesaiMasuk) ? "Jendela absen masuk ditutup" : "Akses tersedia"),
            
            'pesan_keluar' => $now->lt($waktuMulaiKeluar)
                ? "Otorisasi pulang tersedia pukul " . $waktuMulaiKeluar->format('H:i')
                : ($now->gt($waktuSelesaiKeluar) ? "Sinyal operasional berakhir" : "Akses tersedia")
        ];

        // 5. Ambil Riwayat & Data Hari Libur Bulan Ini
        $riwayatAbsen = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $listLiburBulanIni = HariLibur::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        return view('karyawan.dashboard', compact(
            'absenHariIni', 
            'riwayatAbsen', 
            'listLiburBulanIni', 
            'month', 
            'year',
            'statusAbsen'
        ));
    }
}