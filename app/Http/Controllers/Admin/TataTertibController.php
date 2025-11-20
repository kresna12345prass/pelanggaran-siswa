<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterTataTertib;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class TataTertibController extends Controller
{
    // Menampilkan halaman daftar semua tata tertib
    public function index()
    {
        $tataTertib = MasterTataTertib::orderBy('urutan')->get();
        return view('admin.tata_tertib.index', compact('tataTertib'));
    }

    // Menampilkan form untuk menambah tata tertib baru
    public function create()
    {
        return view('admin.tata_tertib.create');
    }

    // Menyimpan tata tertib baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'pasal' => 'required|string|max:50|unique:master_tata_tertib',
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:pasal,ayat,poin',
            'konten_teks' => 'nullable|string',
            'urutan' => 'required|integer|min:0|unique:master_tata_tertib',
        ]);

        MasterTataTertib::create($request->all());

        return redirect()->route('admin.tata_tertib.index')
                         ->with('success', 'Tata tertib berhasil ditambahkan.');
    }

    // Menampilkan detail tata tertib
    public function show(MasterTataTertib $tata_tertib)
    {
        return view('admin.tata_tertib.show', ['tataTertib' => $tata_tertib]);
    }

    // Menampilkan form untuk mengedit tata tertib
    public function edit(MasterTataTertib $tata_tertib)
    {
        return view('admin.tata_tertib.edit', ['tataTertib' => $tata_tertib]);
    }

    // Memperbarui data tata tertib di database
    public function update(Request $request, MasterTataTertib $tata_tertib)
    {
        $request->validate([
            'pasal' => ['required', 'string', 'max:50', Rule::unique('master_tata_tertib')->ignore($tata_tertib->id)],
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:pasal,ayat,poin',
            'konten_teks' => 'nullable|string',
            'urutan' => ['required', 'integer', 'min:0', Rule::unique('master_tata_tertib')->ignore($tata_tertib->id)],
        ]);

        $tata_tertib->update($request->all());

        return redirect()->route('admin.tata_tertib.index')
                         ->with('success', 'Tata tertib berhasil diperbarui.');
    }

    // Menghapus tata tertib dari database
    public function destroy(MasterTataTertib $tata_tertib)
    {
        $tata_tertib->delete();
        
        return redirect()->route('admin.tata_tertib.index')
                         ->with('success', 'Tata tertib berhasil dihapus.');
    }

    // Export data tata tertib ke Excel
    public function export()
    {
        $tataTertib = MasterTataTertib::orderBy('urutan')->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Pasal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Judul</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tipe</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Konten Teks</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Urutan</center></style>'
        ]];
        
        foreach ($tataTertib as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->pasal . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->judul . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tipe . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->konten_teks ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->urutan . '</center></style>'
            ];
        }
        
        $filename = 'tata_tertib_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
