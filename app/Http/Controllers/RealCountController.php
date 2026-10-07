<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilbup;
use App\Models\Paslon;
use App\Models\Dpt;
use App\Models\SuaraPilbup;

class RealCountController extends Controller
{
    public function index(Request $request)
    {
        $pilbups = Pilbup::all();
        $pilbupId = $request->query('pilbup_id');
        $currentPilbup = $pilbupId ? Pilbup::find($pilbupId) : Pilbup::where('status', 'Aktif')->first() ?? Pilbup::first();

        if (!$currentPilbup) {
            return view('frontend.real-count', [
                'pilbups' => $pilbups,
                'currentPilbup' => null,
                'paslons' => collect(),
                'totalDpt' => 0,
                'totalTps' => 0,
                'totalSuaraSah' => 0,
                'rekapKecamatan' => [],
            ]);
        }

        $paslons = Paslon::where('pilbup_id', $currentPilbup->id)->orderBy('no_urut')->get();
        $dpts = Dpt::where('pilbup_id', $currentPilbup->id)->get();
        $suaras = SuaraPilbup::whereIn('dpt_id', $dpts->pluck('id'))->get()->groupBy('dpt_id');

        $totalTps = $dpts->sum('tps');
        $totalDpt = $dpts->sum('dpt');

        // Calculate candidate totals
        $paslonTotals = [];
        foreach ($paslons as $p) {
            $paslonTotals[$p->id] = 0;
        }

        $kecamatans = $dpts->pluck('kecamatan')->unique();
        $rekapKecamatan = [];

        foreach ($kecamatans as $kec) {
            $kecDpts = $dpts->where('kecamatan', $kec);
            $kecTps = $kecDpts->sum('tps');
            $kecPaslonVotes = [];

            foreach ($paslons as $p) {
                $votes = 0;
                foreach ($kecDpts as $d) {
                    $dVotes = $suaras->get($d->id, collect());
                    $pVote = $dVotes->firstWhere('paslon_id', $p->id);
                    $votes += $pVote ? $pVote->suara : 0;
                }
                $kecPaslonVotes[$p->id] = $votes;
                $paslonTotals[$p->id] += $votes;
            }

            $kecTotal = array_sum($kecPaslonVotes);
            $rekapKecamatan[] = [
                'kecamatan' => $kec,
                'tps' => $kecTps,
                'suara_paslon' => $kecPaslonVotes,
                'total_suara' => $kecTotal,
            ];
        }

        $totalSuaraSah = array_sum($paslonTotals);

        return view('frontend.real-count', compact(
            'pilbups',
            'currentPilbup',
            'paslons',
            'totalDpt',
            'totalTps',
            'paslonTotals',
            'totalSuaraSah',
            'rekapKecamatan'
        ));
    }
}
