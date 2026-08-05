<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    public function error()
    {
        return view('errorsrole');
    }

   public function maintance(Request $request)
{
    // Keluar paksa apabila pengguna masih memiliki sesi login.
    if (Auth::check()) {
        Auth::logout();
    }

    // Hapus session lama agar dashboard tidak dapat dibuka dari history.
    if ($request->hasSession()) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return response()
        ->view('maintance', [], 503)
        ->header(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, max-age=0'
        )
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
}

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email'    => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Security: cegah session fixation

            // Redirect berdasarkan role
            return match (Auth::user()->role) {
                'admin', 'operator', 'dasawisma', 'akundemo' => redirect()->route('dashboard'),
                default => redirect()->route('dashboard'), // fallback
            };
        }

        // Jika gagal login
        return redirect()->back()
            ->withInput()                    // agar old('email') tetap terisi
            ->withErrors(['login' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
