<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Menampilkan daftar personil (Karyawan & Mentor)
    public function index()
    {
        // Admin bisa melihat semua kecuali dirinya sendiri
        $users = User::where('role', '!=', User::ROLE_ADMIN)->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Update data profil, Role, atau Reset Password
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi Role agar hanya bisa diisi admin, mentor, atau karyawan
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_MENTOR, User::ROLE_KARYAWAN])],
            'divisi' => 'required',
            'no_wa' => 'required',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name'   => $request->name,
            'role'   => $request->role, // Admin sekarang bisa mengubah role user
            'divisi' => $request->divisi,
            'no_wa'  => $request->no_wa,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', "Otoritas personil {$user->name} berhasil diperbarui.");
    }

    // Menghapus personil
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', "Personel telah dihapus dari sistem.");
    }
}