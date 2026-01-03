<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsMentor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login dan apakah role-nya adalah mentor
        if (Auth::check() && Auth::user()->role === 'mentor') {
            return $next($request);
        }

        // Jika bukan mentor, arahkan ke dashboard karyawan
        return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Mentor.');
    }
}