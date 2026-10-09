<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\IklanGambar;

class ArticleController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::with(['category', 'tags', 'comments' => function ($q) {
            $q->where('status', 'Disetujui')->latest();
        }])
        ->where('slug', $slug)
        ->firstOrFail();

        // Increment views count
        $article->increment('dibaca');

        // Related articles in same category
        $relatedArticles = Article::where('status', 'Terbit')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('tanggal')
            ->take(4)
            ->get();

        // Popular articles
        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        // Trending tags
        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        // Banner Ads
        $iklanSidebar = IklanGambar::where('posisi', 'like', '%Sidebar%')->where('status', 'Tayang')->first();
        $iklanArtikel = IklanGambar::where('posisi', 'like', '%Artikel%')->where('status', 'Tayang')->first();

        return view('frontend.article-detail', compact(
            'article',
            'relatedArticles',
            'popularArticles',
            'trendingTags',
            'iklanSidebar',
            'iklanArtikel'
        ));
    }

    public function storeComment(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        Comment::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'komentar' => $request->komentar,
            'status' => 'Disetujui',
        ]);

        return back()->with('success', 'Komentar Anda berhasil dipublikasikan!');
    }
}
