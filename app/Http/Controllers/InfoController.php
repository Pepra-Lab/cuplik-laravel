<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\InfoPage;
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
        $page = InfoPage::olehSlug('redaksi');
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.redaksi', ['page' => $page, ...$sidebar]);
    }

    public function pedoman()
    {
        $page = InfoPage::olehSlug('pedoman');
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.pedoman', ['page' => $page, ...$sidebar]);
    }

    public function disclaimer()
    {
        $page = InfoPage::olehSlug('disclaimer');
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.disclaimer', ['page' => $page, ...$sidebar]);
    }

    public function iklan()
    {
        $page = InfoPage::olehSlug('iklan');
        $sidebar = $this->getCommonSidebar();
        return view('frontend.info.iklan', ['page' => $page, ...$sidebar]);
    }
}
