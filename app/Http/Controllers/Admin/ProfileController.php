<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Profil akun milik diri sendiri — tersedia untuk semua peran CMS
 * (Super Admin, Admin, Redaktur, Member). Beda dengan AdminUserController
 * (kelola akun orang lain) dan AdminSettingController (profil situs),
 * controller ini hanya menyentuh data akun milik user yang sedang login,
 * sehingga tidak butuh pembatasan peran dan tidak bisa mengubah role/status.
 */
class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nm_inisial' => 'nullable|string|max:10',
            'tempat_lahir' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:300',
            'password' => 'nullable|string|min:8|confirmed',
            // Kata sandi saat ini hanya dicek kalau user memang mengisi kata sandi baru.
            // (Jangan pakai required_with: aturan "required*" membuat rule current_password
            // ikut jalan walau field kosong, sehingga profil tanpa ganti sandi selalu gagal.)
            'current_password' => $request->filled('password')
                ? ['required', 'current_password']
                : ['nullable'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi untuk mengganti kata sandi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
        ]);

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'nm_inisial' => $data['nm_inisial'] ?? null,
            'tempat_lahir' => $data['tempat_lahir'] ?? null,
            'tgl_lahir' => $data['tgl_lahir'] ?? null,
            'telp' => $data['telp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];
            // Password sudah diganti: hitung ulang status "password bawaan" di sesi ini.
            $request->session()->forget(['default_pw_state', 'default_pw_alert_shown']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
