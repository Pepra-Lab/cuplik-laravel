<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Tag;
use App\Models\IklanGambar;

class CategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->with('tags')->firstOrFail();

        $selectedTagSlug = $request->query('tag');
        $query = Article::where('status', 'Terbit')
            ->where('category_id', $category->id);

        if ($selectedTagSlug) {
            $query->whereHas('tags', function ($q) use ($selectedTagSlug) {
                $q->where('slug', $selectedTagSlug);
            });
        }

        $articles = $query->latest('tanggal')->paginate(12)->withQueryString();

        $popularArticles = Article::where('status', 'Terbit')
            ->where('category_id', $category->id)
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        $iklanSidebar = IklanGambar::active()->where('posisi', 'like', '%Sidebar%')->first();

        return view('frontend.category', compact(
            'category',
            'articles',
            'popularArticles',
            'trendingTags',
            'iklanSidebar',
            'selectedTagSlug'
        ));
    }
}
