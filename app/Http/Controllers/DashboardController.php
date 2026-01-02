<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request; // Pastikan ini di-import
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Pastikan menambahkan parameter Request $request di dalam fungsi index
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return app(AbsensiController::class)->indexAdmin($request);
        }

        // PAKSA INPUT MENJADI INTEGER (Mencegah TypeError Carbon)
        $month = intval($request->input('month', date('m')));
        $year = intval($request->input('year', date('Y')));

        // Gunakan Carbon untuk menormalisasi bulan (Contoh: jika bulan 13, otomatis jadi bulan 1 tahun depan)
        $dateContext = \Carbon\Carbon::createFromDate($year, $month, 1);
        $month = $dateContext->month;
        $year = $dateContext->year;

        $today = \Carbon\Carbon::today()->toDateString();

        $absenHariIni = \App\Models\Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        $riwayatAbsen = \App\Models\Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        return view('karyawan.dashboard', compact('absenHariIni', 'riwayatAbsen', 'month', 'year'));
    }
}
