<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminInfoPageController extends Controller
{
    public function edit(string $slug): View
    {
        $this->pastikanSlugValid($slug);

        $page = InfoPage::olehSlug($slug);

        return view('admin.info-pages.edit', compact('page'));
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        $this->pastikanSlugValid($slug);

        $validated = $request->validate([
            'badge' => 'nullable|string|max:100',
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'konten' => 'required|string',
        ]);

        InfoPage::olehSlug($slug)->update($validated);

        return redirect()->route('admin.info-pages.edit', $slug)->with('success', 'Halaman berhasil diperbarui!');
    }

    private function pastikanSlugValid(string $slug): void
    {
        abort_unless(array_key_exists($slug, InfoPage::SLUGS), 404);
    }
}
