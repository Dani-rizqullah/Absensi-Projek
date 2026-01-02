<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * DASHBOARD MONITORING ADMIN
     */
    public function indexAdmin(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $jamMasukKantor = Pengaturan::getVal('jam_masuk', '08:00');
        $jamPulangKantor = Pengaturan::getVal('jam_pulang', '17:00');

        $search = $request->input('search');
        $divisi = $request->input('divisi');

        // 1. Ambil DAFTAR DIVISI UNIK dari database untuk dropdown filter
        $daftarDivisi = User::whereNotNull('divisi')
            ->where('divisi', '!=', '')
            ->distinct()
            ->pluck('divisi');

        // 2. Ambil data user dengan filter
        $users = User::where('role', 'karyawan')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($divisi, fn($q) => $q->where('divisi', $divisi))
            ->with(['absensis' => fn($q) => $q->where('tanggal', $today)])
            ->get();

        $absensiHariIni = $users->map(function ($user) use ($jamMasukKantor, $jamPulangKantor, $now) {
            $absen = $user->absensis->first();
            $jamSekarang = $now->format('H:i');
            $statusLabel = 'Tanpa Keterangan';

            if ($absen) {
                if (in_array($absen->status, ['Selesai', 'Sakit', 'Izin'])) {
                    $statusLabel = $absen->status;
                } elseif ($jamSekarang > $jamPulangKantor && !$absen->jam_keluar) {
                    $statusLabel = 'Terlambat Laporan';
                } else {
                    $statusLabel = $absen->status;
                }
            } elseif ($jamSekarang <= $jamMasukKantor) {
                $statusLabel = 'Belum Hadir';
            }

            return ['user' => $user, 'absen' => $absen, 'status_label' => $statusLabel];
        });

        $pengajuanPending = Absensi::with('user')
            ->where('approval_status', 'Pending')
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalKaryawan = $users->count();
        $totalHadir = Absensi::where('tanggal', $today)->whereIn('status', ['Hadir', 'Selesai'])->count();
        $totalTerlambat = Absensi::where('tanggal', $today)->where('status', 'Terlambat')->count();
        $totalIzinSakit = Absensi::where('tanggal', $today)->whereIn('status', ['Sakit', 'Izin'])->count();
        $menungguApproval = $pengajuanPending->count();

        return view('admin.dashboard', compact(
            'absensiHariIni',
            'pengajuanPending',
            'totalHadir',
            'totalTerlambat',
            'totalIzinSakit',
            'menungguApproval',
            'totalKaryawan',
            'daftarDivisi'
        ));
    }

    /**
     * PERSETUJUAN ADMIN
     */
    public function approve($id)
    {
        $absen = Absensi::findOrFail($id);
        $user = User::find($absen->user_id);

        $jamMasukStandar = Pengaturan::getVal('jam_masuk', '08:00:00');
        $jamPulangStandar = Pengaturan::getVal('jam_pulang', '17:00:00');

        if ($absen->status == 'Hadir') {
            $absen->update([
                'jam_masuk' => $jamMasukStandar,
                'jam_keluar' => $jamPulangStandar,
                'approval_status' => 'Approved',
                'status' => 'Selesai'
            ]);
            $user->increment('poin', 10);
        } else {
            $absen->update(['approval_status' => 'Approved']);
        }

        return back()->with('success', "Pengajuan {$absen->status} berhasil disetujui.");
    }

    public function reject($id)
    {
        $absen = Absensi::findOrFail($id);
        $absen->update(['approval_status' => 'Rejected']);
        return back()->with('error', 'Pengajuan telah ditolak.');
    }

    /**
     * REPORTING CENTER
     */
    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $divisi = $request->input('divisi');
        $search = $request->input('search');

        $daftarDivisi = User::whereNotNull('divisi')->where('divisi', '!=', '')->distinct()->pluck('divisi');

        $users = User::where('role', 'karyawan')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->when($divisi, function ($q) use ($divisi) {
                $q->where('divisi', $divisi);
            })
            ->with(['absensis' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            }])->get();

        $daysInMonth = Carbon::create($tahun, $bulan)->daysInMonth;
        $dateContext = Carbon::create($tahun, $bulan, 1);

        return view('admin.laporan', compact('users', 'bulan', 'tahun', 'divisi', 'daysInMonth', 'dateContext', 'daftarDivisi', 'search'));
    }

    /**
     * PENGAJUAN BACKDATE (Sakit, Izin, Lupa Absen) - FIX FINAL
     */
    public function storeBackdate(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'kategori' => 'required|in:lupa,sakit,izin',
            'alasan_lupa_absen' => 'required|string|min:5',
            'bukti_alasan' => 'required|image|max:2048',
        ]);

        $userId = Auth::id();
        $fotoPath = $request->file('bukti_alasan')->store('bukti_khusus', 'public');
        $statusMap = ['lupa' => 'Hadir', 'sakit' => 'Sakit', 'izin' => 'Izin'];

        // Menggunakan updateOrCreate untuk memastikan jika data sudah ada (misal sudah klik absen masuk) 
        // maka akan di-update menjadi pengajuan 'Pending', bukan ditolak.
        Absensi::updateOrCreate(
            [
                'user_id' => $userId,
                'tanggal' => $request->tanggal,
            ],
            [
                'status' => $statusMap[$request->kategori],
                'alasan_lupa_absen' => $request->alasan_lupa_absen,
                'kegiatan_harian' => $request->kegiatan_harian ?? null,
                'progres_perubahan' => $request->progres_perubahan ?? null,
                'foto_bukti' => $fotoPath,
                'approval_status' => 'Pending',
                'jam_masuk' => null, // Reset jam agar diisi Admin saat Approve
                'jam_keluar' => null,
            ]
        );

        return back()->with('success', 'Pengajuan berhasil terkirim ke Admin.');
    }

    /**
     * ABSEN MASUK HARIAN
     */
    public function storeMasuk(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        if (Absensi::where('user_id', $user->id)->where('tanggal', $today)->exists()) {
            return back()->with('error', 'Anda sudah absen masuk hari ini.');
        }

        $jamMasukKantor = Pengaturan::getVal('jam_masuk', '08:00');
        $isTepatWaktu = $now->format('H:i') <= $jamMasukKantor;
        $status = $isTepatWaktu ? 'Hadir' : 'Terlambat';
        $poin = $isTepatWaktu ? 10 : -5;

        $user->increment('poin', $poin);

        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'jam_masuk' => $now->format('H:i:s'),
            'status' => $status,
            'approval_status' => 'Auto',
            'poin_didapat' => $poin
        ]);

        return back()->with('success', "Absen $status berhasil.");
    }

    /**
     * ABSEN KELUAR HARIAN
     */
    public function storeKeluar(Request $request)
    {
        $request->validate([
            'kegiatan_harian' => 'required|string|min:20',
            'progres_perubahan' => 'required|string',
            'foto_bukti' => 'required|image|max:2048',
        ]);

        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $absen = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if (!$absen || $absen->jam_keluar) {
            return back()->with('error', 'Gagal melakukan absen keluar.');
        }

        $fotoPath = $request->file('foto_bukti')->store('bukti_absen', 'public');
        $jamPulangKantor = Pengaturan::getVal('jam_pulang', '17:00');
        $tepatWaktuLapor = Carbon::now()->format('H:i') >= $jamPulangKantor;

        $poin = $tepatWaktuLapor ? 5 : -2;
        $user->increment('poin', $poin);

        $absen->update([
            'jam_keluar' => Carbon::now()->format('H:i:s'),
            'kegiatan_harian' => $request->kegiatan_harian,
            'progres_perubahan' => $request->progres_perubahan,
            'foto_bukti' => $fotoPath,
            'status' => 'Selesai',
        ]);

        return back()->with('success', 'Laporan kerja terkirim.');
    }
}