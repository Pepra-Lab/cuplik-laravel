<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Article;
use App\Models\Tag;

class VideoController extends Controller
{
    public function index()
    {
        $featuredVideo = Video::where('status', 'Tayang')->latest('tanggal')->first();
        $videos = Video::where('status', 'Tayang')
            ->when($featuredVideo, fn($q) => $q->where('id', '!=', $featuredVideo->id))
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

        return view('frontend.video', compact(
            'featuredVideo',
            'videos',
            'popularArticles',
            'trendingTags'
        ));
    }

    public function show(string $slug)
    {
        $video = Video::where('slug', $slug)->firstOrFail();
        $video->increment('dibaca');

        $relatedVideos = Video::where('status', 'Tayang')
            ->where('id', '!=', $video->id)
            ->latest('tanggal')
            ->take(6)
            ->get();

        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        return view('frontend.video-detail', compact(
            'video',
            'relatedVideos',
            'popularArticles',
            'trendingTags'
        ));
    }
}
