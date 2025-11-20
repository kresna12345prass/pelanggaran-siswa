<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterSanksiBertahap;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class AturanSanksiController extends Controller
{
    // Menampilkan daftar semua aturan sanksi bertahap
    public function index()
    {
        $sanksi = MasterSanksiBertahap::orderBy('poin_minimal')->get();
        return view('admin.aturan_sanksi.index', compact('sanksi'));
    }

    // Menampilkan form untuk menambah aturan sanksi baru
    public function create()
    {
        return view('admin.aturan_sanksi.create');
    }

    // Menyimpan aturan sanksi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_sanksi' => 'required|string|max:255|unique:master_sanksi_bertahap',
            'poin_minimal' => 'required|integer|min:0',
            'poin_maksimal' => 'required|integer|min:0|gte:poin_minimal',
            'deskripsi_tindakan' => 'nullable|string',
        ]);

        MasterSanksiBertahap::create($request->all());

        return redirect()->route('admin.aturan_sanksi.index')
                         ->with('success', 'Aturan sanksi berhasil ditambahkan.');
    }

    // Menampilkan detail aturan sanksi
    public function show(MasterSanksiBertahap $aturan_sanksi)
    {
        return view('admin.aturan_sanksi.show', ['sanksi' => $aturan_sanksi]);
    }

    // Menampilkan form untuk mengedit aturan sanksi
    public function edit(MasterSanksiBertahap $aturan_sanksi)
    {
        return view('admin.aturan_sanksi.edit', ['sanksi' => $aturan_sanksi]);
    }

    // Memperbarui data aturan sanksi di database
    public function update(Request $request, MasterSanksiBertahap $aturan_sanksi)
    {
        $request->validate([
            'nama_sanksi' => ['required', 'string', 'max:255', Rule::unique('master_sanksi_bertahap')->ignore($aturan_sanksi->id)],
            'poin_minimal' => 'required|integer|min:0',
            'poin_maksimal' => 'required|integer|min:0|gte:poin_minimal',
            'deskripsi_tindakan' => 'nullable|string',
        ]);

        $aturan_sanksi->update($request->all());

        return redirect()->route('admin.aturan_sanksi.index')
                         ->with('success', 'Aturan sanksi berhasil diperbarui.');
    }

    // Menghapus aturan sanksi dari database
    public function destroy(MasterSanksiBertahap $aturan_sanksi)
    {
        $aturan_sanksi->delete();
        
        return redirect()->route('admin.aturan_sanksi.index')
                         ->with('success', 'Aturan sanksi berhasil dihapus.');
    }

    // Export data aturan sanksi ke Excel
    public function export()
    {
        $sanksi = MasterSanksiBertahap::orderBy('poin_minimal')->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Sanksi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin Minimal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin Maksimal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Deskripsi Tindakan</center></style>'
        ]];
        
        foreach ($sanksi as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_sanksi . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin_minimal . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin_maksimal . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->deskripsi_tindakan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'aturan_sanksi_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
