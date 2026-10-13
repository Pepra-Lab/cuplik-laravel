<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
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

        $query = Article::with('category', 'tags')->visibleTo($request->user());

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
        $staff = User::whereIn('role', User::ROLES)->orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags', 'staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        $baseSlug = Str::slug($validated['judul']);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $validated['slug'] = $slug;
        $validated['tone'] = $validated['tone'] ?: '#eaf3ec';
        $validated['user_id'] = $request->user()->id;

        // Berita dari Member selalu menunggu review admin.
        if ($request->user()->isMember()) {
            $validated['status'] = 'Review';
        }

        $article = Article::create($validated);

        $article->tags()->sync($this->resolveTagIds($request));

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        $categories = Category::orderBy('nama')->get();
        $tags = Tag::orderBy('nama')->get();
        $staff = User::whereIn('role', User::ROLES)->orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'staff'));
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $validated = $request->validate($this->rules($request));

        if ($article->judul !== $validated['judul']) {
            $baseSlug = Str::slug($validated['judul']);
            $slug = $baseSlug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $article->update($validated);

        $article->tags()->sync($this->resolveTagIds($request));

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dihapus!');
    }

    private function rules(Request $request): array
    {
        return [
            'judul' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'editor_nama' => 'nullable|string|max:100',
            'penulis_nama' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'lead' => 'nullable|string',
            'isi' => 'required|string',
            'foto' => 'nullable|string',
            'tone' => 'nullable|string|max:20',
            'status' => $request->user()->isMember() ? 'nullable' : 'required|in:Terbit,Review,Draft',
            'tanggal' => 'required|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'new_tags' => 'nullable|string|max:255',
        ];
    }

    /**
     * Gabungkan tag yang dipilih dari daftar (checkbox) dengan tag baru yang
     * diketik manual lewat kolom "Tambah Tag Baru". Hanya Admin, Super Admin,
     * dan Redaktur (isCmsStaff) yang boleh membuat tag baru dari sini — Member
     * tetap hanya bisa memilih dari tag yang sudah ada, kontennya pun masih
     * harus lewat review admin sebelum tayang.
     *
     * Maksimal 5 tag baru per submit untuk mencegah satu artikel membanjiri
     * daftar tag dengan entri yang sembarangan.
     */
    private function resolveTagIds(Request $request): array
    {
        $tagIds = array_map('intval', $request->input('tags', []));

        $rawNewTags = (string) $request->input('new_tags', '');
        if ($rawNewTags !== '' && $request->user()->isCmsStaff()) {
            $names = collect(explode(',', $rawNewTags))
                ->map(fn ($name) => trim($name))
                ->filter()
                ->unique(fn ($name) => Str::lower($name))
                ->take(5);

            foreach ($names as $name) {
                $tagIds[] = Tag::findOrCreateByName($name)->id;
            }
        }

        return array_values(array_unique($tagIds));
    }
}
