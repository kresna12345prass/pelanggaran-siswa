<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSXGen;

class UserController extends Controller
{
    // Menampilkan halaman daftar semua pengguna
    public function index(Request $request)
    {
        $users = User::latest()->get(); 
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form untuk menambah pengguna baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users',
            'email'        => 'required|string|email|max:255|unique:users|ends_with:@gmail.com',
            'password'     => 'required|string|min:8|confirmed',
            'level'        => 'required|in:admin,kepsek,guru,siswa,ortu,bk,kesiswaan,wali_kelas',
            'spesialisasi' => 'nullable|string|max:255',
            'can_verify'   => 'nullable|boolean',
        ]);

        // Validasi kepala sekolah hanya boleh satu
        if ($request->level === 'kepsek' && User::where('level', 'kepsek')->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kepala sekolah sudah ada. Hanya boleh ada satu kepala sekolah.');
        }

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'level'        => $request->level,
            'spesialisasi' => $request->spesialisasi,
            'can_verify'   => $request->boolean('can_verify'),
        ]);
        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    // Menampilkan halaman detail pengguna
    public function show(User $user)
    {

        return view('admin.users.show', compact('user'));
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui data pengguna di database
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'        => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id), 'ends_with:@gmail.com'],
            'password'     => 'nullable|string|min:8|confirmed',
            'level'        => 'required|in:admin,kepsek,guru,siswa,ortu,bk,kesiswaan,wali_kelas',
            'spesialisasi' => 'nullable|string|max:255',
            'can_verify'   => 'nullable|boolean',
        ]);

        // Validasi kepala sekolah hanya boleh satu
        if ($request->level === 'kepsek' && $user->level !== 'kepsek' && User::where('level', 'kepsek')->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kepala sekolah sudah ada. Hanya boleh ada satu kepala sekolah.');
        }

        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->spesialisasi = $request->spesialisasi;
        $user->can_verify = $request->boolean('can_verify');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('admin.users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna dari database
    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        if ($user->id == 1) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Akun Super Admin (ID 1) tidak dapat dihapus.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }

    // Export data pengguna ke Excel
    public function export()
    {
        $users = User::all();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Lengkap</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Username</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Email</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Level</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Spesialisasi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Can Verify</center></style>'
        ]];
        
        foreach ($users as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_lengkap . '</style>',
                '<style border="thin" border-color="#000000">' . $item->username . '</style>',
                '<style border="thin" border-color="#000000">' . $item->email . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->level . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->spesialisasi ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->can_verify ? 'Ya' : 'Tidak') . '</center></style>'
            ];
        }
        
        $filename = 'pengguna_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}