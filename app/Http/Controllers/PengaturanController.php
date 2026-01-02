<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\HariLibur;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturans = Pengaturan::all();
        // Mengurutkan hari libur dari yang terdekat (mendatang)
        $hariLiburs = HariLibur::orderBy('tanggal', 'asc')->get();
        
        return view('admin.pengaturan', compact('pengaturans', 'hariLiburs'));
    }

    public function update(Request $request)
    {
        // Ambil semua input kecuali token CSRF dan method PUT
        $allInputs = $request->except('_token', '_method');

        foreach ($allInputs as $key => $value) {
            // Kita hanya memproses key yang ada di tabel pengaturan
            // Logic: Jika admin mengosongkan input, kita tidak update (opsional)
            if ($value !== null) {
                Pengaturan::where('key', $key)->update([
                    'value' => $value 
                    // Kolom 'type' dihapus karena sekarang semua input di View adalah 'time'
                ]);
            }
        }

        return back()->with('success', 'Seluruh parameter operasional berbasis waktu berhasil disinkronisasi.');
    }

    /**
     * Fitur Tambah Hari Libur
     */
    public function storeLibur(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal|after_or_equal:today',
            'keterangan' => 'required|string|max:255'
        ], [
            'tanggal.unique' => 'Tanggal ini sudah terdaftar dalam kalender off.',
            'tanggal.after_or_equal' => 'Tidak dapat mendaftarkan hari libur pada tanggal yang sudah lewat.'
        ]);

        HariLibur::create($request->all());
        
        return back()->with('success', 'Sinyal hari libur berhasil didaftarkan ke sistem.');
    }

    /**
     * Fitur Hapus Hari Libur
     */
    public function destroyLibur($id)
    {
        HariLibur::findOrFail($id)->delete();
        
        return back()->with('success', 'Jadwal operasional telah diaktifkan kembali (Libur dihapus).');
    }
}