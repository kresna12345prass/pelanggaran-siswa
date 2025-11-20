<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Shuchkin\SimpleXLSXGen;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa (untuk DataTables).
     */
    public function index()
    {
        $siswa = Siswa::with(['kelas', 'user'])->latest()->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Menampilkan form untuk menambah siswa baru.
     */
    public function create()
    {
        // Ambil data kelas untuk dropdown
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    /**
     * Menyimpan siswa baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'      => 'required|string|max:50|unique:users',
            'nama_siswa'    => 'required|string|max:255',
            'email'         => 'required|email|unique:users|ends_with:@gmail.com',
            'password'      => 'required|string|min:6',
            'nis'           => 'required|string|max:12|unique:siswa',
            'nisn'          => 'required|digits:10|unique:siswa',
            'kelas_id'      => 'required|integer|exists:kelas,id',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama'         => 'nullable|string|max:50',
            'alamat'        => 'nullable|string',
            'no_telepon'    => 'nullable|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = User::create([
            'username'      => $request->username,
            'nama_lengkap'  => $request->nama_siswa,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'level'         => 'siswa',
        ]);

        $data = $request->except(['foto', 'username', 'email', 'password']);
        $data['user_id'] = $user->id;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('siswa_foto', 'public');
            $data['foto'] = $path;
        }

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman detail spesifik siswa.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'user']);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Menampilkan form untuk mengedit siswa.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $siswa->load('user');
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'username'      => ['required', 'string', 'max:50', Rule::unique('users')->ignore($siswa->user_id)],
            'nama_siswa'    => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($siswa->user_id), 'ends_with:@gmail.com'],
            'password'      => 'nullable|string|min:6',
            'nis'           => ['required', 'string', 'max:12', Rule::unique('siswa')->ignore($siswa->id)],
            'nisn'          => ['required', 'digits:10', Rule::unique('siswa')->ignore($siswa->id)],
            'kelas_id'      => 'required|integer|exists:kelas,id',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama'         => 'nullable|string|max:50',
            'alamat'        => 'nullable|string',
            'no_telepon'    => 'nullable|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $userData = [
            'username'      => $request->username,
            'nama_lengkap'  => $request->nama_siswa,
            'email'         => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $siswa->user->update($userData);

        $data = $request->except(['foto', 'username', 'email', 'password']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $path = $request->file('foto')->store('siswa_foto', 'public');
            $data['foto'] = $path;
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus siswa dari database.
     */
    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->user->delete();
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function export()
    {
        $siswa = Siswa::with(['kelas', 'user'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NISN</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tempat Lahir</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Lahir</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Kelamin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Agama</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Alamat</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No Telepon</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Email</center></style>'
        ]];
        
        foreach ($siswa as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->nis . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->nisn . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_siswa . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->tempat_lahir ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_lahir ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->jenis_kelamin == 'L' ? 'Laki-laki' : ($item->jenis_kelamin == 'P' ? 'Perempuan' : '-')) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->agama ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->alamat ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->no_telepon ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->user?->email ?? '-') . '</style>'
            ];
        }
        
        $filename = 'siswa_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}