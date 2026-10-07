<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\IklanGambar;

class InfoController extends Controller
{
    private function getCommonSidebar()
    {
        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        $iklanSidebar = IklanGambar::where('posisi', 'like', '%Sidebar%')->where('status', 'Tayang')->first();

        return compact('popularArticles', 'trendingTags', 'iklanSidebar');
    }

    public function redaksi()
    {
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.redaksi', $sidebar);
    }

    public function pedoman()
    {
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.pedoman', $sidebar);
    }

    public function disclaimer()
    {
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.disclaimer', $sidebar);
    }

    public function iklan()
    {
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.iklan', $sidebar);
    }
}
