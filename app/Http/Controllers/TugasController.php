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

        $query = $user->tugas()->with('mentor');

        $tugasActive = (clone $query)->where('tgl_mulai', '<=', $now)
            ->wherePivotNotIn('status', ['selesai', 'Selesai'])
            ->orderBy('tgl_selesai', 'asc')
            ->get();

        $tugasUpcoming = (clone $query)->where('tgl_mulai', '>', $now)
            ->orderBy('tgl_mulai', 'asc')
            ->get();

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
            'file_hasil' => [
                'nullable',
                'file',
                'mimes:pdf,zip,jpg,jpeg,png', 
                'mimetypes:application/pdf,application/zip,image/jpeg,image/png',
                'max:5120'
            ],
            'link_tautan' => 'nullable|url',
            'pesan_karyawan' => 'required|string',
        ]);

        $user = Auth::user();
        $filePath = null;

        if ($request->hasFile('file_hasil')) {
            $file = $request->file('file_hasil');
            
            $originalName = $file->getClientOriginalName();
            if (preg_match('/\.(php|phtml|php3|php4|php5|phar|sh|pl|py|jsp|asp|cgi)/i', $originalName)) {
                return back()->with('error', 'Konten ilegal terdeteksi dalam nama file!');
            }

            $filePath = $file->store('hasil_tugas', 'public');
        }

        $pivotData = $user->tugas()->where('tugas_id', $request->tugas_id)->first()->pivot;

        if ($filePath && $pivotData->file_hasil) {
            Storage::disk('public')->delete($pivotData->file_hasil);
        }

        $user->tugas()->updateExistingPivot($request->tugas_id, [
            'status' => 'dikumpulkan',
            'file_hasil' => $filePath ?? $pivotData->file_hasil,
            'link_tautan' => $request->link_tautan,
            'pesan_karyawan' => $request->pesan_karyawan,
            'alasan_tolak' => null, // Reset alasan tolak jika user mengirimkan revisi baru
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
            'status' => 'selesai',
            'alasan_tolak' => null // Pastikan bersih saat sudah disetujui
        ]);

        return back()->with('success', 'Status tugas diperbarui menjadi Selesai.');
    }

    /**
     * MENTOR: Menolak laporan tugas agar karyawan bisa kirim ulang
     */
    public function tolakLaporan(Request $request, $tugasId, $userId)
    {
        // Validasi input alasan penolakan
        $request->validate([
            'alasan_tolak' => 'required|string|min:5'
        ]);

        $tugas = Tugas::findOrFail($tugasId);

        if (Auth::id() !== $tugas->mentor_id && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Otoritas ditolak.');
        }

        $karyawan = $tugas->karyawans()->where('user_id', $userId)->first();
        
        if ($karyawan && $karyawan->pivot->file_hasil) {
            Storage::disk('public')->delete($karyawan->pivot->file_hasil);
        }

        // Kembalikan status ke 'pending' dan simpan alasan penolakan
        $tugas->karyawans()->updateExistingPivot($userId, [
            'status' => 'pending',
            'file_hasil' => null,
            'alasan_tolak' => $request->alasan_tolak, // Simpan alasan penolakan
            'tgl_pengumpulan' => null
        ]);

        return back()->with('success', 'Laporan tugas telah ditolak. Karyawan akan melihat alasan perbaikan.');
    }

    /**
     * MENTOR: Menghapus misi (Fitur Terminate Mission)
     */
    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);

        if (Auth::id() !== $tugas->mentor_id && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Otoritas ditolak.');
        }

        // Hapus semua file terkait di pivot table sebelum menghapus tugas
        foreach($tugas->karyawans as $karyawan) {
            if($karyawan->pivot->file_hasil) {
                Storage::disk('public')->delete($karyawan->pivot->file_hasil);
            }
        }

        $tugas->delete();

        return back()->with('success', 'Misi berhasil dihentikan dan dihapus dari sistem.');
    }
}