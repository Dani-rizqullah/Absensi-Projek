<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TugasController extends Controller
{
    /**
     * KARYAWAN: Menampilkan halaman monitoring tugas (Mission Hub)
     */
    public function indexKaryawan()
    {
        $user = Auth::user();
        $now = now();

        // Gunakan with('mentor') untuk menghindari N+1 query problem
        $query = $user->tugas()->with('mentor');

        // 1. TUGAS AKTIF: Sudah mulai DAN status belum 'selesai'
        // Kita gunakan wherePivotNotIn untuk keamanan jika ada variasi huruf besar
        $tugasActive = (clone $query)->where('tgl_mulai', '<=', $now)
            ->wherePivotNotIn('status', ['selesai', 'Selesai'])
            ->orderBy('tgl_selesai', 'asc')
            ->get();

        // 2. TUGAS MENDATANG: Belum masuk tanggal mulai
        $tugasUpcoming = (clone $query)->where('tgl_mulai', '>', $now)
            ->orderBy('tgl_mulai', 'asc')
            ->get();

        // 3. TUGAS SELESAI (ARSIP): Status sudah 'selesai'
        $tugasCompleted = (clone $query)->wherePivotIn('status', ['selesai', 'Selesai'])
            ->orderBy('tgl_pengumpulan', 'desc')
            ->get();

        return view('karyawan.tugas.index', compact('tugasActive', 'tugasUpcoming', 'tugasCompleted'));
    }

    /**
     * MENTOR: Menyimpan tugas baru dan delegasi ke tim
     */
    public function store(Request $request)
    {
        $mentor = Auth::user();

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'karyawan_ids' => 'required|array',
        ]);

        $tugas = Tugas::create([
            'mentor_id' => $mentor->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'divisi' => $mentor->divisi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
        ]);

        $tugas->karyawans()->attach($request->karyawan_ids, ['status' => 'pending']);

        return back()->with('success', 'Misi/Tugas berhasil didelegasikan ke tim.');
    }

    /**
     * MENTOR: Memperbarui data tugas yang sudah ada
     */
    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'karyawan_ids' => 'required|array',
        ]);

        $tugas->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
        ]);

        // Parameter 'false' memastikan progress karyawan lama tidak terhapus jika mereka masih dipilih
        $tugas->karyawans()->syncWithPivotValues($request->karyawan_ids, ['status' => 'pending'], false);

        return back()->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * KARYAWAN: Mengirimkan hasil kerja (Lapor Progres)
     */
    public function kumpulTugas(Request $request)
    {
        $request->validate([
            'tugas_id' => 'required|exists:tugas,id',
            'file_hasil' => 'nullable|file|mimes:pdf,zip,jpg,png|max:5120',
            'link_tautan' => 'nullable|url',
            'pesan_karyawan' => 'required|string',
        ]);

        $user = Auth::user();
        $filePath = null;

        // Ambil data lama untuk cek file lama jika ingin dihapus (opsional)
        if ($request->hasFile('file_hasil')) {
            $filePath = $request->file('file_hasil')->store('hasil_tugas', 'public');
        }

        $user->tugas()->updateExistingPivot($request->tugas_id, [
            'status' => 'dikumpulkan',
            'file_hasil' => $filePath,
            'link_tautan' => $request->link_tautan,
            'pesan_karyawan' => $request->pesan_karyawan,
            'tgl_pengumpulan' => now(),
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan. Menunggu review mentor.');
    }

    /**
     * MENTOR: Menandai tugas sudah selesai/valid
     */
    public function tandaiSelesai(Request $request, $tugasId, $userId)
    {
        $tugas = Tugas::findOrFail($tugasId);

        if (Auth::id() !== $tugas->mentor_id && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Otoritas ditolak.');
        }

        $tugas->karyawans()->updateExistingPivot($userId, [
            'status' => 'selesai'
        ]);

        return back()->with('success', 'Status tugas diperbarui menjadi Selesai.');
    }
}