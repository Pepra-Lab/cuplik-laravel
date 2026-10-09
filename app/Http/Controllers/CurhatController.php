<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curhat;
use App\Models\Article;
use App\Models\Tag;

class CurhatController extends Controller
{
    public function index()
    {
        $curhats = Curhat::where('status', 'Tampil')
            ->latest('tanggal')
            ->paginate(15);

        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        return view('frontend.curhat', compact('curhats', 'popularArticles', 'trendingTags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengirim' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'pesan' => 'required|string|min:5|max:1000',
        ]);

        Curhat::create([
            'user_id' => $request->user()->id,
            'pengirim' => $request->pengirim ?: 'Anonim',
            'lokasi' => $request->lokasi ?: 'Indramayu',
            'pesan' => $request->pesan,
            'tanggal' => now()->toDateString(),
            'status' => 'Baru', // Needs admin approval before 'Tampil'
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Aspirasi & keluh kesah Anda berhasil dikirim! Menunggu moderasi redaksi.',
            ]);
        }

        return back()->with('success', 'Aspirasi & keluh kesah Anda berhasil dikirim! Menunggu moderasi redaksi.');
    }
}
