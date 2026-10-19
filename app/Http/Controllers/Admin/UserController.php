<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? User::where('role', 'admin')->first();
        return view('admin.users.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user() ?? User::where('role', 'admin')->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email login admin wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Keamanan: Wajib input kata sandi yang sedang dipakai sebelum bisa membuat kata sandi baru
        if ($request->filled('password') || $request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ], [
                'current_password.required' => 'Anda wajib memasukkan kata sandi yang sedang digunakan saat ini untuk verifikasi keamanan.',
                'password.required' => 'Kata sandi baru tidak boleh kosong.',
                'password.min' => 'Kata sandi baru minimal terdiri dari 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok. Silakan ketik ulang dengan benar.',
            ]);

            // Cek apakah kata sandi saat ini cocok dengan yang tersimpan di database
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Kata sandi saat ini yang Anda masukkan salah. Verifikasi keamanan gagal!',
                ])->withInput();
            }

            // Pastikan kata sandi baru tidak sama persis dengan kata sandi lama
            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'password' => 'Kata sandi baru tidak boleh sama dengan kata sandi yang sedang aktif.',
                ])->withInput();
            }

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Profil dan pengaturan keamanan akun Admin Pemilik berhasil diperbarui!');
    }
}
