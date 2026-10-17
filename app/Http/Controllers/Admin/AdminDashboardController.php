<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Video;
use App\Models\IklanBaris;
use App\Models\Curhat;
use App\Models\User;
use App\Models\Poll;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return redirect()->route('admin.articles.index');
        }

        $now = Carbon::now();
        $month = $request->query('month', $now->month);
        $year = $request->query('year', $now->year);

        $totalBerita = Article::count();
        $totalVideo = Video::count();
        $totalIklan = IklanBaris::count();
        $totalCurhat = Curhat::where('status', 'Baru')->count();
        $totalDibaca = Article::sum('dibaca');

        // Productivity matrix by Editor
        $editors = User::whereIn('role', [...User::MANAGER_ROLES, User::ROLE_REDAKTUR])->get();
        $writers = User::whereIn('role', User::CONTRIBUTOR_ROLES)->get();

        $articlesThisMonth = Article::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();

        $articlesToday = Article::whereDate('tanggal', Carbon::today())->get();
        $articlesThisYear = Article::whereYear('tanggal', $year)->get();

        $editorStats = [];
        foreach ($editors as $ed) {
            $harian = $articlesToday->where('editor_nama', $ed->name)->count();
            $bulanan = $articlesThisMonth->where('editor_nama', $ed->name)->count();
            $tahunan = $articlesThisYear->where('editor_nama', $ed->name)->count();
            $editorStats[] = [
                'nama' => $ed->name,
                'peran' => $ed->role,
                'harian' => $harian,
                'bulanan' => $bulanan,
                'tahunan' => $tahunan,
            ];
        }

        $writerStats = [];
        foreach ($writers as $wr) {
            $harian = $articlesToday->where('penulis_nama', $wr->name)->count();
            $bulanan = $articlesThisMonth->where('penulis_nama', $wr->name)->count();
            $tahunan = $articlesThisYear->where('penulis_nama', $wr->name)->count();
            $writerStats[] = [
                'nama' => $wr->name,
                'peran' => $wr->role,
                'harian' => $harian,
                'bulanan' => $bulanan,
                'tahunan' => $tahunan,
            ];
        }

        $recentArticles = Article::with('category')->latest('tanggal')->take(5)->get();
        $popularArticles = Article::with('category')->orderByDesc('dibaca')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBerita',
            'totalVideo',
            'totalIklan',
            'totalCurhat',
            'totalDibaca',
            'editorStats',
            'writerStats',
            'recentArticles',
            'popularArticles',
            'month',
            'year'
        ));
    }
}
