<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->orderBy('urutan')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'urutan' => 'nullable|integer',
            'tampil' => 'required|in:Ya,Tidak',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        $validated['urutan'] = $validated['urutan'] ?? (Category::max('urutan') + 1);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'urutan' => 'nullable|integer',
            'tampil' => 'required|in:Ya,Tidak',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
