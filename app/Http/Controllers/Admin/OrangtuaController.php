<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orangtua;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Shuchkin\SimpleXLSXGen;

class OrangtuaController extends Controller
{
    // Menampilkan halaman daftar semua data orang tua
    public function index()
    {
        $orangtua = Orangtua::with(['user', 'siswa'])->oldest()->get();
        return view('admin.orangtua.index', compact('orangtua'));
    }

    // Menampilkan form untuk menambah data orang tua baru
    public function create()
    {
        $siswa = Siswa::orderBy('nama_siswa')->get();
        return view('admin.orangtua.create', compact('siswa'));
    }

    // Memproses penyimpanan data orang tua baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'username'      => 'required|string|max:50|unique:users',
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|string|min:6',
            'siswa_id'      => 'required|integer|exists:siswa,id',
            'hubungan'      => 'nullable|string|max:50',
            'no_telepon'    => 'nullable|string|max:20',
            'pendidikan'    => 'nullable|string|max:50',
            'pekerjaan'     => 'nullable|string|max:100',
            'alamat'        => 'nullable|string',
        ]);

        // Membuat akun user untuk orang tua
        $user = User::create([
            'username'      => $request->username,
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'level'         => 'ortu',
        ]);

        // Menyimpan data profil orang tua
        Orangtua::create([
            'user_id'     => $user->id,
            'siswa_id'    => $request->siswa_id,
            'hubungan'    => $request->hubungan,
            'no_telepon'  => $request->no_telepon,
            'pendidikan'  => $request->pendidikan,
            'pekerjaan'   => $request->pekerjaan,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->route('admin.orangtua.index')
                         ->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    // Menampilkan detail data orang tua
    public function show(Orangtua $orangtua)
    {
        $orangtua->load(['user', 'siswa']);
        return view('admin.orangtua.show', compact('orangtua'));
    }

    // Menampilkan form untuk mengedit data orang tua
    public function edit(Orangtua $orangtua)
    {
        $siswa = Siswa::orderBy('nama_siswa')->get();
        $orangtua->load('user');
        return view('admin.orangtua.edit', compact('orangtua', 'siswa'));
    }

    // Memproses update data orang tua
    public function update(Request $request, Orangtua $orangtua)
    {
        $request->validate([
            'username'      => ['required', 'string', 'max:50', Rule::unique('users')->ignore($orangtua->user_id)],
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($orangtua->user_id)],
            'password'      => 'nullable|string|min:6',
            'siswa_id'      => 'required|integer|exists:siswa,id',
            'hubungan'      => 'nullable|string|max:50',
            'no_telepon'    => 'nullable|string|max:20',
            'pendidikan'    => 'nullable|string|max:50',
            'pekerjaan'     => 'nullable|string|max:100',
            'alamat'        => 'nullable|string',
        ]);

        $userData = [
            'username'      => $request->username,
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $orangtua->user->update($userData);

        $orangtua->update([
            'siswa_id'    => $request->siswa_id,
            'hubungan'    => $request->hubungan,
            'no_telepon'  => $request->no_telepon,
            'pendidikan'  => $request->pendidikan,
            'pekerjaan'   => $request->pekerjaan,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->route('admin.orangtua.index')
                         ->with('success', 'Data orang tua berhasil diperbarui.');
    }

    // Menghapus data orang tua beserta akun user-nya
    public function destroy(Orangtua $orangtua)
    {
        $orangtua->user->delete();
        $orangtua->delete();

        return redirect()->route('admin.orangtua.index')
                         ->with('success', 'Data orang tua berhasil dihapus.');
    }

    // Export data orang tua ke Excel
    public function export()
    {
        $orangtua = Orangtua::with(['user', 'siswa'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Orang Tua</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Hubungan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No Telepon</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Pendidikan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Pekerjaan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Alamat</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Email</center></style>'
        ]];
        
        foreach ($orangtua as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->user?->nama_lengkap ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->hubungan ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->no_telepon ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->pendidikan ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->pekerjaan ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->alamat ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->user?->email ?? '-') . '</style>'
            ];
        }
        
        $filename = 'orangtua_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
