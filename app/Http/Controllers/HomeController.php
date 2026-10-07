<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Banner;
use App\Models\Poll;
use App\Models\Curhat;
use App\Models\Video;
use App\Models\IklanGambar;
use App\Models\IklanBaris;
use App\Models\NewsletterSubscriber;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Hero Banners & Breaking News
        $banners = Banner::where('tampil', 'Ya')->orderBy('urutan')->get();
        $breakingNews = Article::where('status', 'Terbit')->latest('tanggal')->take(5)->get();

        // 2. Headline Articles
        $headlineMain = Article::where('status', 'Terbit')->latest('tanggal')->first();
        $headlineSub = Article::where('status', 'Terbit')
            ->where('id', '!=', $headlineMain?->id)
            ->latest('tanggal')
            ->take(4)
            ->get();

        // 3. Terpopuler (Most Read)
        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
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
                $q->where('status', 'Terbit')->latest('tanggal')->take(4);
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
        $iklanBaris = IklanBaris::where('status', 'Disetujui')->latest('tanggal')->take(6)->get();

        return view('frontend.home', compact(
            'banners',
            'breakingNews',
            'headlineMain',
            'headlineSub',
            'popularArticles',
            'trendingTags',
            'categories',
            'activePoll',
            'curhats',
            'videos',
            'iklanHeader',
            'iklanSidebar',
            'iklanBaris'
        ));
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            ['tanggal' => now()->toDateString()]
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Terima kasih telah berlangganan newsletter CuplikCom!']);
        }

        return back()->with('success', 'Terima kasih telah berlangganan newsletter CuplikCom!');
    }
}
