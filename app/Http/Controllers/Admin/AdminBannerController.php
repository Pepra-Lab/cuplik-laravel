<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Setting;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('urutan')->get();
        $setting = Setting::current();
        return view('admin.banners.index', compact('banners', 'setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|string',
            'tautan' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'tampil' => 'required|in:Ya,Tidak',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? (Banner::max('urutan') + 1);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|string',
            'tautan' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'tampil' => 'required|in:Ya,Tidak',
        ]);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus!');
    }
}
