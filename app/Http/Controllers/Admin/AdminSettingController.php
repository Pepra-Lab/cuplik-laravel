<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Tab "Profil Situs" — identitas portal, kontak, dan sosial media.
     */
    public function profil()
    {
        $setting = Setting::current();
        return view('admin.settings.profil', compact('setting'));
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'favicon' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string',
        ]);

        Setting::current()->update($validated);

        return redirect()->route('admin.settings.profil')->with('success', 'Profil situs berhasil diperbarui!');
    }

    /**
     * Jeda pergantian slide Banner Beranda (detik), ditampilkan di halaman Banner.
     */
    public function updateBannerJeda(Request $request)
    {
        $validated = $request->validate([
            'banner_jeda' => 'required|integer|min:3|max:60',
        ]);

        Setting::current()->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Jeda slide banner berhasil disimpan!');
    }

    /**
     * Tab "Newsletter" — aktif/nonaktif form langganan & subjek default.
     */
    public function updateNewsletterConfig(Request $request)
    {
        $validated = $request->validate([
            'newsletter_aktif' => 'nullable|boolean',
            'newsletter_subjek_default' => 'nullable|string|max:255',
        ]);
        $validated['newsletter_aktif'] = $request->boolean('newsletter_aktif');

        Setting::current()->update($validated);

        return redirect()->route('admin.newsletter.index')->with('success', 'Pengaturan newsletter berhasil disimpan!');
    }
}
