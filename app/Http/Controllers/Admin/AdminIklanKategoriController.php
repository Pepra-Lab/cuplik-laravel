<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IklanKategori;
use Illuminate\Http\Request;

class AdminIklanKategoriController extends Controller
{
    public function index()
    {
        $kategoris = IklanKategori::orderBy('nama')->get();
        return view('admin.settings.kategori-iklan', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:iklan_kategoris,nama',
        ]);

        IklanKategori::create($validated);

        return redirect()->route('admin.iklan-kategori.index')->with('success', 'Kategori iklan teks berhasil ditambahkan!');
    }

    public function update(Request $request, IklanKategori $iklanKategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:iklan_kategoris,nama,' . $iklanKategori->id,
        ]);

        $iklanKategori->update($validated);

        return redirect()->route('admin.iklan-kategori.index')->with('success', 'Kategori iklan teks berhasil diperbarui!');
    }

    public function destroy(IklanKategori $iklanKategori)
    {
        if ($iklanKategori->iklanBaris()->exists()) {
            return redirect()->route('admin.iklan-kategori.index')->with('error', 'Kategori ini masih dipakai oleh Iklan Teks, tidak bisa dihapus.');
        }

        $iklanKategori->delete();

        return redirect()->route('admin.iklan-kategori.index')->with('success', 'Kategori iklan teks berhasil dihapus!');
    }
}
