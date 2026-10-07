<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pilbup;
use App\Models\Paslon;
use App\Models\Dpt;
use App\Models\SuaraPilbup;

class AdminRealCountController extends Controller
{
    public function index(Request $request)
    {
        $pilbups = Pilbup::all();
        $pilbupId = $request->query('pilbup_id');
        $currentPilbup = $pilbupId ? Pilbup::find($pilbupId) : Pilbup::where('status', 'Aktif')->first() ?? Pilbup::first();

        if (!$currentPilbup) {
            return view('admin.realcount.index', [
                'pilbups' => $pilbups,
                'currentPilbup' => null,
                'paslons' => collect(),
                'dpts' => collect(),
                'suaras' => collect(),
                'totalDpt' => 0,
                'totalTps' => 0,
                'paslonTotals' => [],
                'totalSuaraSah' => 0,
            ]);
        }

        $paslons = Paslon::where('pilbup_id', $currentPilbup->id)->orderBy('no_urut')->get();
        $dpts = Dpt::where('pilbup_id', $currentPilbup->id)->orderBy('kecamatan')->orderBy('desa')->get();
        $suaras = SuaraPilbup::whereIn('dpt_id', $dpts->pluck('id'))->get()->groupBy('dpt_id');

        $totalTps = $dpts->sum('tps');
        $totalDpt = $dpts->sum('dpt');

        $paslonTotals = [];
        foreach ($paslons as $p) {
            $paslonTotals[$p->id] = 0;
        }

        foreach ($dpts as $d) {
            $dVotes = $suaras->get($d->id, collect());
            foreach ($paslons as $p) {
                $pVote = $dVotes->firstWhere('paslon_id', $p->id);
                $paslonTotals[$p->id] += $pVote ? $pVote->suara : 0;
            }
        }

        $totalSuaraSah = array_sum($paslonTotals);

        return view('admin.realcount.index', compact(
            'pilbups',
            'currentPilbup',
            'paslons',
            'dpts',
            'suaras',
            'totalDpt',
            'totalTps',
            'paslonTotals',
            'totalSuaraSah'
        ));
    }

    public function updateSuara(Request $request)
    {
        $request->validate([
            'dpt_id' => 'required|exists:dpts,id',
            'paslon_id' => 'required|exists:paslons,id',
            'suara' => 'required|integer|min:0',
        ]);

        SuaraPilbup::updateOrCreate(
            [
                'dpt_id' => $request->dpt_id,
                'paslon_id' => $request->paslon_id,
            ],
            [
                'suara' => $request->suara,
            ]
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Suara berhasil disimpan!']);
        }

        return back()->with('success', 'Suara berhasil disimpan!');
    }
}
