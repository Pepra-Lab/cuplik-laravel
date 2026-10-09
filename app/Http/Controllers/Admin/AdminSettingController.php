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
}
