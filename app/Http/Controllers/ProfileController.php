<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil kru.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi identitas kru (Identity Log).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Mengambil user aktif
        $user = $request->user();

        // Mengisi data berdasarkan request yang sudah divalidasi
        // Pastikan field 'divisi' dan 'no_wa' sudah masuk di ProfileUpdateRequest
        $user->fill($request->validated());

        // Jika email berubah, reset verifikasi (Opsional tergantung setting Laravel)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Redirect dengan pesan sukses ala Tactical
        return Redirect::route('profile.edit')->with('success', 'Konfigurasi identitas kru berhasil diperbarui.');
    }

    /**
     * Terminasi Akun (Permanent Deletion).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi password sebelum terminasi data
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout dari sesi taktis
        Auth::logout();

        // Hapus data dari pusat kendali (Database)
        $user->delete();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Protokol terminasi selesai. Data kru telah dihapus.');
    }
}