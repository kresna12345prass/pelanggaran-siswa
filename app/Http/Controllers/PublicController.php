<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTataTertib; // <-- Import model

class PublicController extends Controller
{
    // Menampilkan halaman landing page publik (welcome)
    public function index()
    {
        // Mengambil data Pasal 6 dari database
        $pasal6 = MasterTataTertib::where('pasal', 'Pasal 6')
                                  ->orderBy('urutan')
                                  ->get();
        
        // Mengambil data Pasal 7 dari database
        $pasal7 = MasterTataTertib::where('pasal', 'Pasal 7')
                                  ->orderBy('urutan')
                                  ->get();

        // Mengirim data ke view
        return view('welcome', [
            'dataPasal6' => $pasal6,
            'dataPasal7' => $pasal7,
        ]);
    }
}