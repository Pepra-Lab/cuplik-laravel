<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Poll;
use App\Models\Curhat;
use App\Models\Video;
use App\Models\IklanGambar;
use App\Models\IklanBaris;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Breaking News
        $breakingNews = Article::where('status', 'Terbit')->latest('tanggal')->take(5)->get();

        // 2. Berita Pilihan (3 items for the green container below the hero)
        $curatedNews = Article::where('status', 'Terbit')
            ->latest('tanggal')
            ->take(3)
            ->with('category')
            ->get();

        // 3. Terpopuler (Most Read)
        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->with('category')
            ->get();

        // 4. Trending Tags
        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        // 5. Category-wise News Feeds
        $categories = Category::where('tampil', 'Ya')
            ->where('slug', '!=', 'video')
            ->orderBy('urutan')
            ->with(['articles' => function ($q) {
                $q->where('status', 'Terbit')->latest('tanggal')->take(4)->with('category');
            }])
            ->get();

        // 6. Active Poll
        $activePoll = Poll::where('status', 'Aktif')->with('options')->first();

        // 7. Curhat / Keluh Kesah Rakyat
        $curhats = Curhat::where('status', 'Tampil')
            ->latest('created_at')
            ->take(6)
            ->get();

        // 8. Videos
        $videos = Video::where('status', 'Tayang')
            ->latest('tanggal')
            ->take(4)
            ->get();

        // 9. Advertisements
        $iklanHeader = IklanGambar::where('posisi', 'like', '%Header%')->where('status', 'Tayang')->first();
        $iklanSidebar = IklanGambar::where('posisi', 'like', '%Sidebar%')->where('status', 'Tayang')->first();
        $iklanBetweenCategory = IklanGambar::where('posisi', 'like', '%Article%')->orWhere('posisi', 'like', '%Header%')->where('status', 'Tayang')->first();
        $iklanBaris = IklanBaris::where('status', 'Disetujui')->latest('tanggal')->take(6)->get();

        return view('frontend.home', compact(
            'breakingNews',
            'curatedNews',
            'popularArticles',
            'trendingTags',
            'categories',
            'activePoll',
            'curhats',
            'videos',
            'iklanHeader',
            'iklanSidebar',
            'iklanBetweenCategory',
            'iklanBaris'
        ));
    }

}
