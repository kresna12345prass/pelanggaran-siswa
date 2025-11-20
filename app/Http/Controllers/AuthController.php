<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
// Model TahunAjaran tidak kita perlukan di sini

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function loginView()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->level);
        }
        return view('auth.login');
    }

    // Memproses login user
    public function loginProcess(Request $request): RedirectResponse
    {
        // Validasi input email dan password
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email', // <-- REVISI
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        // Menyiapkan kredensial untuk autentikasi
        $credentials = [
            'email'    => $request->email, // <-- REVISI
            'password' => $request->password,
        ];

        // Melakukan proses autentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user()->level);
        }

        // Jika gagal login, kirim pesan error
        return redirect()->route('login')
            ->withInput()
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.']);
    }

    // Memproses logout user
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('welcome');
    }

    // Helper untuk redirect ke dashboard sesuai role user
    private function redirectBasedOnRole($level)
    {
        switch ($level) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
            case 'kesiswaan':
                return redirect()->intended('/kesiswaan/dashboard');
            case 'guru':
                return redirect()->intended('/guru/dashboard');
            case 'wali_kelas':
                return redirect()->intended('/wali_kelas/dashboard');
            case 'bk':
                return redirect()->intended('/bk/dashboard');
            case 'kepsek':
                return redirect()->intended('/kepsek/dashboard');
            case 'siswa':
                return redirect()->intended('/siswa/dashboard');
            case 'ortu':
                return redirect()->intended('/ortu/dashboard');
            default:
                return redirect()->intended('/');
        }
    }
}