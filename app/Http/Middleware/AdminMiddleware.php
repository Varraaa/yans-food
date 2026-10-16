<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifikasi apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu untuk mengakses panel admin.');
        }

        $user = Auth::user();

        // 2. Verifikasi otorisasi hak akses admin
        // Yan's Food dikelola oleh satu akun administrator (Owner/Admin)
        if (isset($user->role) && !in_array(strtolower($user->role), ['admin', 'owner', 'superadmin'])) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'Akses ditolak. Akun Anda tidak memiliki hak akses Administrator.');
        }

        return $next($request);
    }
}
