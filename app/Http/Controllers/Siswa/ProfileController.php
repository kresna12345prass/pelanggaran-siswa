<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil siswa
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data siswa tidak ditemukan']);
        }
        
        return view('siswa.profile.index', compact('siswa', 'user'));
    }
}
