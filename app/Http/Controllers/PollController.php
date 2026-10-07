<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Article;
use App\Models\Tag;

class PollController extends Controller
{
    public function index()
    {
        $activePoll = Poll::where('status', 'Aktif')->with('options')->first();
        $pastPolls = Poll::where('status', 'Nonaktif')->with('options')->latest()->paginate(10);

        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        return view('frontend.polling', compact(
            'activePoll',
            'pastPolls',
            'popularArticles',
            'trendingTags'
        ));
    }

    public function vote(Request $request)
    {
        $request->validate([
            'poll_option_id' => 'required|exists:poll_options,id',
        ]);

        $option = PollOption::findOrFail($request->poll_option_id);
        $option->increment('suara');

        $poll = $option->poll()->with('options')->first();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pilihan Anda berhasil disimpan!',
                'poll' => $poll,
                'options' => $poll->options,
                'total_votes' => $poll->total_votes,
            ]);
        }

        return back()->with('success', 'Pilihan Anda berhasil disimpan!');
    }
}
