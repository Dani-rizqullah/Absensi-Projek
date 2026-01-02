<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar kru
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Update data profil atau Reset Password
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'divisi' => 'required',
            'no_wa' => 'required',
            'password' => 'nullable|string|min:8', // Password opsional, diisi jika ingin reset saja
        ]);

        $data = [
            'name' => $request->name,
            'divisi' => $request->divisi,
            'no_wa' => $request->no_wa,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', "Data {$user->name} berhasil diperbarui.");
    }

    // Menghapus karyawan yang keluar
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', "Personel telah dihapus dari sistem.");
    }
}