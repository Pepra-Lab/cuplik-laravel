<?php

namespace App\Services;

use App\Models\Dpt;
use App\Models\Paslon;
use App\Models\Pilbup;
use App\Models\SuaraPilbup;
use Illuminate\Support\Collection;

class RealCountService
{
    /**
     * Resolve which Pilbup to display: an explicit id, otherwise the active one,
     * otherwise the first available record.
     */
    public function resolveCurrentPilbup(Collection $pilbups, ?int $pilbupId): ?Pilbup
    {
        if ($pilbupId) {
            $selected = $pilbups->firstWhere('id', $pilbupId);
            if ($selected) {
                return $selected;
            }
        }

        return $pilbups->firstWhere('status', 'Aktif') ?? $pilbups->first();
    }

    /**
     * Build the full tabulation snapshot for a given Pilbup: paslons, per-wilayah
     * DPT rows, recorded votes, running totals per paslon, and aggregate figures.
     */
    public function buildSummary(Pilbup $pilbup): array
    {
        $paslons = Paslon::where('pilbup_id', $pilbup->id)->orderBy('no_urut')->get();
        $dpts = Dpt::where('pilbup_id', $pilbup->id)
            ->orderBy('kecamatan')
            ->orderBy('desa')
            ->get();

        $suaras = SuaraPilbup::whereIn('dpt_id', $dpts->pluck('id'))
            ->get()
            ->groupBy('dpt_id');

        $paslonTotals = $paslons->mapWithKeys(fn ($p) => [$p->id => 0])->all();

        foreach ($dpts as $dpt) {
            $dptVotes = $suaras->get($dpt->id, collect());
            foreach ($paslons as $paslon) {
                $vote = $dptVotes->firstWhere('paslon_id', $paslon->id);
                $paslonTotals[$paslon->id] += $vote->suara ?? 0;
            }
        }

        $totalSuaraSah = array_sum($paslonTotals);

        return [
            'paslons' => $paslons,
            'dpts' => $dpts,
            'suaras' => $suaras,
            'totalTps' => (int) $dpts->sum('tps'),
            'totalDpt' => (int) $dpts->sum('dpt'),
            'paslonTotals' => $paslonTotals,
            'totalSuaraSah' => (int) $totalSuaraSah,
        ];
    }

    /**
     * Group a tabulation summary into per-kecamatan recap rows, used by the
     * public real count page.
     */
    public function buildRekapKecamatan(Collection $paslons, Collection $dpts, Collection $suaras): array
    {
        $rekap = [];

        foreach ($dpts->pluck('kecamatan')->unique() as $kecamatan) {
            $kecDpts = $dpts->where('kecamatan', $kecamatan);
            $kecPaslonVotes = [];

            foreach ($paslons as $paslon) {
                $votes = 0;
                foreach ($kecDpts as $dpt) {
                    $vote = $suaras->get($dpt->id, collect())->firstWhere('paslon_id', $paslon->id);
                    $votes += $vote->suara ?? 0;
                }
                $kecPaslonVotes[$paslon->id] = $votes;
            }

            $rekap[] = [
                'kecamatan' => $kecamatan,
                'tps' => (int) $kecDpts->sum('tps'),
                'suara_paslon' => $kecPaslonVotes,
                'total_suara' => array_sum($kecPaslonVotes),
            ];
        }

        return $rekap;
    }

    /**
     * Persist (create or update) a single paslon's vote count for one DPT row.
     * Guards against mixing data from a different Pilbup than the DPT belongs to.
     */
    public function saveSuara(Dpt $dpt, Paslon $paslon, int $suara): SuaraPilbup
    {
        if ($dpt->pilbup_id !== $paslon->pilbup_id) {
            abort(422, 'Data DPT dan Paslon berasal dari Pilbup yang berbeda.');
        }

        return SuaraPilbup::updateOrCreate(
            ['dpt_id' => $dpt->id, 'paslon_id' => $paslon->id],
            ['suara' => $suara]
        );
    }
}
