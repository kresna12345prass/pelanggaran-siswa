<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil orang tua dan anak
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        return view('ortu.profile.index', compact('orangtua', 'siswa', 'user'));
    }
}
