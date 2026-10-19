<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Article;
use App\Models\IklanGambar;

class TagController extends Controller
{
    public function show(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $articles = $tag->articles()
            ->where('status', 'Terbit')
            ->latest('tanggal')
            ->paginate(12);

        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        $iklanSidebar = IklanGambar::active()->where('posisi', 'like', '%Sidebar%')->first();

        return view('frontend.tag', compact(
            'tag',
            'articles',
            'popularArticles',
            'trendingTags',
            'iklanSidebar'
        ));
    }
}
