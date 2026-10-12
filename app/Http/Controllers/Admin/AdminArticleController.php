<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class AdminArticleController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $categoryId = $request->query('kategori_id');
        $status = $request->query('status');

        $query = Article::with('category', 'tags');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'ilike', "%{$q}%")
                    ->orWhere('penulis_nama', 'ilike', "%{$q}%")
                    ->orWhere('editor_nama', 'ilike', "%{$q}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $articles = $query->latest('tanggal')->paginate(10)->withQueryString();
        $categories = Category::orderBy('nama')->get();

        return view('admin.articles.index', compact('articles', 'categories', 'q', 'categoryId', 'status'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        $tags = Tag::orderBy('nama')->get();
        $staff = User::whereIn('role', ['Admin', 'Super Admin', 'Editor', 'Penulis', 'Reporter', 'Redaksi'])->orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags', 'staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'editor_nama' => 'nullable|string|max:100',
            'penulis_nama' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'isi' => 'required|string',
            'gambar_1' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'gambar_2' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'foto_posisi' => 'nullable|string|in:header,p1,p2,p3,p4,p5,bottom',
            'foto_2_posisi' => 'nullable|string|in:header,p1,p2,p3,p4,p5,bottom',
            'caption_foto' => 'nullable|string|max:255',
            'caption_foto_2' => 'nullable|string|max:255',
            'tone' => 'nullable|string|max:20',
            'status' => 'required|in:Terbit,Review,Draft',
            'tanggal' => 'required|date',
            'tags' => 'nullable|array',
            'custom_tags' => 'nullable',
        ]);

        // 1. Slug otomatis / manual ringkas & unik
        $rawSlug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Article::generateConciseSlug($validated['judul']);

        $validated['slug'] = Article::generateUniqueSlug($rawSlug);

        // 2. Lead otomatis dari paragraf pertama isi berita (maks 500 karakter, potong batas kata)
        $validated['lead'] = Article::generateLead($validated['isi'], 500);

        // 3. Upload Gambar 1 & Gambar 2
        if ($request->hasFile('gambar_1')) {
            $path1 = $request->file('gambar_1')->store('berita', 'public');
            $validated['foto'] = 'storage/' . $path1;
        } else {
            $validated['foto'] = null;
        }

        if ($request->hasFile('gambar_2')) {
            $path2 = $request->file('gambar_2')->store('berita', 'public');
            $validated['foto_2'] = 'storage/' . $path2;
        } else {
            $validated['foto_2'] = null;
        }

        $validated['foto_posisi'] = ($validated['foto_posisi'] ?? null) ?: 'header';
        $validated['foto_2_posisi'] = ($validated['foto_2_posisi'] ?? null) ?: 'p2';
        $validated['tone'] = ($validated['tone'] ?? null) ?: '#eaf3ec';

        $article = Article::create($validated);

        // 4. Sinkronisasi Tag (termasuk pembuatan tag baru on-the-fly tanpa duplikat case-insensitive)
        $this->syncTags($article, $request->input('tags', []), $request->input('custom_tags'), $validated['category_id']);

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('nama')->get();
        $tags = Tag::orderBy('nama')->get();
        $staff = User::whereIn('role', ['Admin', 'Super Admin', 'Editor', 'Penulis', 'Reporter', 'Redaksi'])->orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'staff'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'editor_nama' => 'nullable|string|max:100',
            'penulis_nama' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'isi' => 'required|string',
            'gambar_1' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'gambar_2' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'hapus_gambar_1' => 'nullable|boolean',
            'hapus_gambar_2' => 'nullable|boolean',
            'foto_posisi' => 'nullable|string|in:header,p1,p2,p3,p4,p5,bottom',
            'foto_2_posisi' => 'nullable|string|in:header,p1,p2,p3,p4,p5,bottom',
            'caption_foto' => 'nullable|string|max:255',
            'caption_foto_2' => 'nullable|string|max:255',
            'tone' => 'nullable|string|max:20',
            'status' => 'required|in:Terbit,Review,Draft',
            'tanggal' => 'required|date',
            'tags' => 'nullable|array',
            'custom_tags' => 'nullable',
        ]);

        // 1. Slug handling (bisa diedit redaktur, tetap dipastikan ringkas & unik)
        if ($request->filled('slug')) {
            $cleanSlug = Str::slug($request->slug);
            $validated['slug'] = Article::generateUniqueSlug($cleanSlug, $article->id);
        } elseif ($article->judul !== $validated['judul']) {
            $baseSlug = Article::generateConciseSlug($validated['judul']);
            $validated['slug'] = Article::generateUniqueSlug($baseSlug, $article->id);
        } else {
            $validated['slug'] = $article->slug;
        }

        // 2. Lead otomatis dari paragraf pertama
        $validated['lead'] = Article::generateLead($validated['isi'], 500);

        // 3. Upload Gambar 1
        if ($request->hasFile('gambar_1')) {
            $rawFoto = $article->getRawOriginal('foto');
            if ($rawFoto && str_contains($rawFoto, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $rawFoto));
            }
            $path1 = $request->file('gambar_1')->store('berita', 'public');
            $validated['foto'] = 'storage/' . $path1;
        } elseif ($request->boolean('hapus_gambar_1')) {
            $rawFoto = $article->getRawOriginal('foto');
            if ($rawFoto && str_contains($rawFoto, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $rawFoto));
            }
            $validated['foto'] = null;
        } else {
            unset($validated['foto']);
        }

        // Upload Gambar 2
        if ($request->hasFile('gambar_2')) {
            $rawFoto2 = $article->getRawOriginal('foto_2');
            if ($rawFoto2 && str_contains($rawFoto2, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $rawFoto2));
            }
            $path2 = $request->file('gambar_2')->store('berita', 'public');
            $validated['foto_2'] = 'storage/' . $path2;
        } elseif ($request->boolean('hapus_gambar_2')) {
            $rawFoto2 = $article->getRawOriginal('foto_2');
            if ($rawFoto2 && str_contains($rawFoto2, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $rawFoto2));
            }
            $validated['foto_2'] = null;
        } else {
            unset($validated['foto_2']);
        }

        $validated['foto_posisi'] = ($validated['foto_posisi'] ?? null) ?: ($article->foto_posisi ?: 'header');
        $validated['foto_2_posisi'] = ($validated['foto_2_posisi'] ?? null) ?: ($article->foto_2_posisi ?: 'p2');

        $article->update($validated);

        // 4. Sinkronisasi Tag
        $this->syncTags($article, $request->input('tags', []), $request->input('custom_tags'), $article->category_id);

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        $rawFoto = $article->getRawOriginal('foto');
        if ($rawFoto && str_contains($rawFoto, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $rawFoto));
        }
        $rawFoto2 = $article->getRawOriginal('foto_2');
        if ($rawFoto2 && str_contains($rawFoto2, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $rawFoto2));
        }

        $article->tags()->detach();
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Memproses tag yang dipilih & membuat tag baru secara otomatis di master tag jika belum ada.
     * Mencegah duplikasi secara case-insensitive.
     */
    private function syncTags(Article $article, array $selectedTags = [], $customTagsInput = null, ?int $categoryId = null): void
    {
        $tagIds = [];

        // 1. Tag yang dipilih dari checkbox / array
        foreach ($selectedTags as $tagItem) {
            if (is_numeric($tagItem)) {
                $tagIds[] = (int) $tagItem;
            } else {
                $cleanName = trim($tagItem);
                if ($cleanName !== '') {
                    $tagIds[] = $this->findOrCreateTagId($cleanName, $categoryId);
                }
            }
        }

        // 2. Tag kustom yang diketik baru (bisa berupa array atau string dipisahkan koma)
        if (!empty($customTagsInput)) {
            $items = is_array($customTagsInput) ? $customTagsInput : explode(',', (string) $customTagsInput);
            foreach ($items as $name) {
                $cleanName = trim($name);
                if ($cleanName !== '') {
                    $tagIds[] = $this->findOrCreateTagId($cleanName, $categoryId);
                }
            }
        }

        $article->tags()->sync(array_unique(array_filter($tagIds)));
    }

    /**
     * Cari tag berdasarkan nama (case-insensitive) atau buat baru di master tag.
     */
    private function findOrCreateTagId(string $name, ?int $categoryId = null): int
    {
        $existing = Tag::whereRaw('LOWER(nama) = ?', [mb_strtolower($name, 'UTF-8')])->first();
        if ($existing) {
            return $existing->id;
        }

        $baseSlug = Str::slug($name) ?: 'tag';
        $slug = $baseSlug;
        $counter = 2;
        while (Tag::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $newTag = Tag::create([
            'nama' => $name,
            'slug' => $slug,
        ]);

        return $newTag->id;
    }
}
