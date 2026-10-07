<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\IklanGambar;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $categorySlug = $request->query('kategori');

        $query = Article::where('status', 'Terbit');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'ilike', "%{$q}%")
                    ->orWhere('lead', 'ilike', "%{$q}%")
                    ->orWhere('isi', 'ilike', "%{$q}%")
                    ->orWhere('editor_nama', 'ilike', "%{$q}%")
                    ->orWhere('penulis_nama', 'ilike', "%{$q}%")
                    ->orWhere('lokasi', 'ilike', "%{$q}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('category', function ($c) use ($categorySlug) {
                $c->where('slug', $categorySlug);
            });
        }

        $articles = $query->latest('tanggal')->paginate(10)->withQueryString();

        $categories = Category::where('tampil', 'Ya')->orderBy('urutan')->get();

        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        $iklanSidebar = IklanGambar::where('posisi', 'like', '%Sidebar%')->where('status', 'Tayang')->first();

        return view('frontend.search', compact(
            'q',
            'categorySlug',
            'articles',
            'categories',
            'popularArticles',
            'trendingTags',
            'iklanSidebar'
        ));
    }
}
