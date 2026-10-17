<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap XML otomatis: beranda, kanal, tag, video, dan seluruh berita
     * berstatus "Terbit". Dirujuk dari public/robots.txt agar gampang
     * ditemukan mesin pencari (Google Search Console dsb).
     */
    public function index(): Response
    {
        $urls = collect();

        $urls->push([
            'loc' => url('/'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'hourly',
            'priority' => '1.0',
        ]);

        Category::where('tampil', 'Ya')->get()->each(function (Category $category) use ($urls) {
            $urls->push([
                'loc' => route('category.show', $category->slug),
                'lastmod' => $category->updated_at?->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.7',
            ]);
        });

        Tag::all()->each(function (Tag $tag) use ($urls) {
            $urls->push([
                'loc' => route('tag.show', $tag->slug),
                'lastmod' => $tag->updated_at?->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.5',
            ]);
        });

        Article::where('status', 'Terbit')
            ->orderByDesc('tanggal')
            ->chunk(500, function ($articles) use ($urls) {
                foreach ($articles as $article) {
                    $urls->push([
                        'loc' => route('article.show', $article->slug),
                        'lastmod' => ($article->updated_at ?? $article->tanggal)?->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ]);
                }
            });

        Video::orderByDesc('created_at')->chunk(500, function ($videos) use ($urls) {
            foreach ($videos as $video) {
                $urls->push([
                    'loc' => route('video.show', $video->slug),
                    'lastmod' => $video->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ]);
            }
        });

        $xml = view('sitemap.index', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
