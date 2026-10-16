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
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => 'required_with:password|current_password',
        ]);

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
