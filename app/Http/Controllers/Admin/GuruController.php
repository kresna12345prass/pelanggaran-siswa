<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Shuchkin\SimpleXLSXGen;

class GuruController extends Controller
{
    // Menampilkan halaman daftar semua data guru
    public function index()
    {
        // Mengambil data guru beserta relasi user-nya (eager loading), diurutkan dari yang terbaru
        $guru = Guru::with('user')->latest()->get();
        return view('admin.guru.index', compact('guru'));
    }

    // Menampilkan halaman form untuk menambah guru baru
    public function create()
    {
        return view('admin.guru.create');
    }

    // Memproses penyimpanan data guru baru ke database
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'username'      => 'required|string|max:50|unique:users',
            'nama_guru'     => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email'         => 'required|email|unique:users|ends_with:@gmail.com',
            'password'      => 'required|string|min:6',
            'nip'           => 'required|digits:18|unique:guru',
            'bidang_studi'  => 'nullable|string|max:255',
            'status'        => 'nullable|string|max:50',
            'no_telepon'    => 'nullable|string|max:20',
        ]);

        // Membuat akun User terlebih dahulu (untuk login)
        $user = User::create([
            'username'      => $request->username,
            'nama_lengkap'  => $request->nama_guru,
            'email'         => $request->email,
            'password'      => Hash::make($request->password), // Password di-hash (dienkripsi)
            'level'         => 'guru', // Level otomatis diset sebagai guru
        ]);

        // Menyimpan data profil Guru yang berelasi dengan User di atas
        Guru::create([
            'user_id'       => $user->id, // Mengambil ID dari user yang baru dibuat
            'nip'           => $request->nip,
            'nama_guru'     => $request->nama_guru,
            'jenis_kelamin' => $request->jenis_kelamin,
            'bidang_studi'  => $request->bidang_studi,
            'status'        => $request->status,
            'no_telepon'    => $request->no_telepon,
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.guru.index')
                         ->with('success', 'Data guru berhasil ditambahkan.');
    }

    // Menampilkan detail data guru tertentu
    public function show(Guru $guru)
    {
        // Memuat data user terkait
        $guru->load('user');
        return view('admin.guru.show', compact('guru'));
    }

    // Menampilkan form untuk mengedit data guru
    public function edit(Guru $guru)
    {
        // Memuat data user terkait agar bisa diedit username/email-nya
        $guru->load('user');
        return view('admin.guru.edit', compact('guru'));
    }

    // Memproses update data guru yang sudah ada
    public function update(Request $request, Guru $guru)
    {
        // Validasi input update (menggunakan ignore agar tidak error 'sudah ada' untuk data diri sendiri)
        $request->validate([
            'username'      => ['required', 'string', 'max:50', Rule::unique('users')->ignore($guru->user_id)],
            'nama_guru'     => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($guru->user_id), 'ends_with:@gmail.com'],
            'password'      => 'nullable|string|min:6', // Password boleh kosong jika tidak ingin diganti
            'nip'           => ['required', 'digits:18', Rule::unique('guru')->ignore($guru->id)],
            'bidang_studi'  => 'nullable|string|max:255',
            'status'        => 'nullable|string|max:50',
            'no_telepon'    => 'nullable|string|max:20',
        ]);

        // Menyiapkan data user untuk diupdate
        $userData = [
            'username'      => $request->username,
            'nama_lengkap'  => $request->nama_guru,
            'email'         => $request->email,
        ];

        // Cek apakah kolom password diisi? Jika ya, update password baru
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Update data di tabel Users
        $guru->user->update($userData);

        // Update data di tabel Guru
        $guru->update([
            'nip'           => $request->nip,
            'nama_guru'     => $request->nama_guru,
            'jenis_kelamin' => $request->jenis_kelamin,
            'bidang_studi'  => $request->bidang_studi,
            'status'        => $request->status,
            'no_telepon'    => $request->no_telepon,
        ]);

        return redirect()->route('admin.guru.index')
                         ->with('success', 'Data guru berhasil diperbarui.');
    }

    // Menghapus data guru beserta akun user-nya
    public function destroy(Guru $guru)
    {
        // Hapus akun user terkait terlebih dahulu
        $guru->user->delete();
        // Baru hapus data profil gurunya
        $guru->delete();
        
        return redirect()->route('admin.guru.index')
                         ->with('success', 'Data guru berhasil dihapus.');
    }

    // Mengekspor data guru ke dalam file Excel (.xlsx)
    public function export()
    {
        // Ambil semua data guru beserta user-nya
        $guru = Guru::with('user')->get();
        
        // Membuat Header Tabel Excel dengan Styling (Warna background biru, teks putih)
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIP</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Guru</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Kelamin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Bidang Studi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No Telepon</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Email</center></style>'
        ]];
        
        // Melakukan looping data guru untuk dimasukkan ke baris Excel
        foreach ($guru as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->nip . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_guru . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->jenis_kelamin . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->bidang_studi ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->status ?? 'Aktif') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->no_telepon ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->user?->email ?? '-') . '</style>'
            ];
        }
        
        // Menentukan nama file download
        $filename = 'guru_' . date('Y-m-d_His') . '.xlsx';
        
        // Generate file excel dan langsung download
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}