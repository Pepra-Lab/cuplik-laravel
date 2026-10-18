<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PollController extends Controller
{
    /**
     * Nama cookie penanda identitas pemilih (bukan untuk login, cuma untuk
     * mencegah satu pengunjung vote berkali-kali di polling yang sama).
     * Umur 1 tahun, httpOnly supaya tidak bisa dibaca/diubah lewat JS di
     * browser korban (mencegah pemalsuan token dari console).
     */
    private const VOTER_COOKIE = 'cuplik_voter';
    private const VOTER_COOKIE_MINUTES = 60 * 24 * 365;
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
        $poll = $option->poll()->with('options')->firstOrFail();

        if ($poll->status !== 'Aktif') {
            $message = 'Polling ini sudah tidak aktif.';

            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $message], 422)
                : back()->with('error', $message);
        }

        $voterToken = $request->cookie(self::VOTER_COOKIE) ?: Str::random(40);
        $ipHash = hash('sha256', $request->ip() . '|' . $request->userAgent());

        $alreadyVoted = PollVote::where('poll_id', $poll->id)
            ->where('voter_token', $voterToken)
            ->exists();

        if ($alreadyVoted) {
            $message = 'Anda sudah memilih di polling ini.';

            $response = $request->ajax()
                ? response()->json(['success' => false, 'message' => $message], 409)
                : back()->with('error', $message);

            return $response->cookie(self::VOTER_COOKIE, $voterToken, self::VOTER_COOKIE_MINUTES, null, null, false, true);
        }

        // Race condition pada klik ganda / request paralel ditangani lewat
        // unique constraint (poll_id, voter_token) di tabel poll_votes: kalau
        // dua request datang bersamaan, salah satunya akan gagal insert dan
        // kita anggap sebagai "sudah vote" tanpa menaikkan suara dua kali.
        try {
            DB::transaction(function () use ($poll, $option, $voterToken, $ipHash) {
                PollVote::create([
                    'poll_id' => $poll->id,
                    'poll_option_id' => $option->id,
                    'voter_token' => $voterToken,
                    'ip_hash' => $ipHash,
                ]);

                $option->increment('suara');
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Unique constraint violation -> sudah vote lewat request paralel.
            $message = 'Anda sudah memilih di polling ini.';

            $response = $request->ajax()
                ? response()->json(['success' => false, 'message' => $message], 409)
                : back()->with('error', $message);

            return $response->cookie(self::VOTER_COOKIE, $voterToken, self::VOTER_COOKIE_MINUTES, null, null, false, true);
        }

        $poll->refresh()->load('options');

        $response = $request->ajax()
            ? response()->json([
                'success' => true,
                'message' => 'Pilihan Anda berhasil disimpan!',
                'poll' => $poll,
                'options' => $poll->options,
                'total_votes' => $poll->total_votes,
            ])
            : back()->with('success', 'Pilihan Anda berhasil disimpan!');

        // httpOnly=true supaya token tidak bisa dibaca/dipalsukan lewat JS.
        return $response->cookie(self::VOTER_COOKIE, $voterToken, self::VOTER_COOKIE_MINUTES, null, null, false, true);
    }
}
