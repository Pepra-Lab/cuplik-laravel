<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IklanPosisi;
use Illuminate\Http\Request;

class AdminIklanPosisiController extends Controller
{
    public function index()
    {
        $posisis = IklanPosisi::orderBy('nama')->get();
        return view('admin.settings.posisi', compact('posisis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:iklan_posisis,nama',
            'ukuran' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        IklanPosisi::create($validated);

        return redirect()->route('admin.iklan-posisi.index')->with('success', 'Posisi iklan berhasil ditambahkan!');
    }

    public function update(Request $request, IklanPosisi $iklanPosisi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:iklan_posisis,nama,' . $iklanPosisi->id,
            'ukuran' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $iklanPosisi->update($validated);

        return redirect()->route('admin.iklan-posisi.index')->with('success', 'Posisi iklan berhasil diperbarui!');
    }

    public function destroy(IklanPosisi $iklanPosisi)
    {
        if ($iklanPosisi->iklanGambars()->exists()) {
            return redirect()->route('admin.iklan-posisi.index')->with('error', 'Posisi ini masih dipakai oleh Iklan Gambar, tidak bisa dihapus.');
        }

        $iklanPosisi->delete();

        return redirect()->route('admin.iklan-posisi.index')->with('success', 'Posisi iklan berhasil dihapus!');
    }
}
