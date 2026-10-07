<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IklanGambar;

class AdminIklanGambarController extends Controller
{
    public function index()
    {
        $iklans = IklanGambar::latest()->paginate(10);
        return view('admin.iklan.gambar', compact('iklans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            'ukuran' => 'nullable|string|max:50',
            'link' => 'nullable|string',
            'gambar' => 'nullable|string',
            'mulai' => 'nullable|date',
            'selesai' => 'nullable|date',
            'status' => 'required|in:Tayang,Berakhir,Nonaktif',
        ]);

        IklanGambar::create($validated);

        return redirect()->route('admin.iklan-gambar.index')->with('success', 'Iklan gambar berhasil ditambahkan!');
    }

    public function update(Request $request, IklanGambar $iklanGambar)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            'ukuran' => 'nullable|string|max:50',
            'link' => 'nullable|string',
            'gambar' => 'nullable|string',
            'mulai' => 'nullable|date',
            'selesai' => 'nullable|date',
            'status' => 'required|in:Tayang,Berakhir,Nonaktif',
        ]);

        $iklanGambar->update($validated);

        return redirect()->route('admin.iklan-gambar.index')->with('success', 'Iklan gambar berhasil diperbarui!');
    }

    public function destroy(IklanGambar $iklanGambar)
    {
        $iklanGambar->delete();
        return redirect()->route('admin.iklan-gambar.index')->with('success', 'Iklan gambar berhasil dihapus!');
    }
}
