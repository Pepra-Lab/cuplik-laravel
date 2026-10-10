<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPollController extends Controller
{
    public function index(): View
    {
        $polls = Poll::with('options')->latest()->paginate(10);

        return view('admin.polls.index', compact('polls'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePoll($request);
        $opsi = $this->cleanOptions($validated['opsi']);

        if ($validated['status'] === 'Aktif') {
            Poll::where('status', 'Aktif')->update(['status' => 'Nonaktif']);
        }

        $poll = Poll::create([
            'pertanyaan' => $validated['pertanyaan'],
            'status' => $validated['status'],
        ]);

        $this->syncOptions($poll, $opsi);

        return redirect()->route('admin.polls.index')->with('success', 'Polling baru berhasil dibuat!');
    }

    public function update(Request $request, Poll $poll): RedirectResponse
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'opsi' => 'required|array',
            'opsi.*' => 'nullable|string|max:150',
            'opsi_id' => 'nullable|array',
            'opsi_id.*' => 'nullable|integer',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'opsi.required' => 'Minimal harus ada 2 pilihan jawaban.',
        ]);

        $opsi = $this->cleanOptionsForUpdate($request->input('opsi', []), $request->input('opsi_id', []));

        if ($request->status === 'Aktif') {
            Poll::where('id', '!=', $poll->id)->where('status', 'Aktif')->update(['status' => 'Nonaktif']);
        }

        $poll->update([
            'pertanyaan' => $request->pertanyaan,
            'status' => $request->status,
        ]);

        $this->syncOptionsOnUpdate($poll, $opsi);

        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil diperbarui!');
    }

    public function destroy(Poll $poll): RedirectResponse
    {
        $poll->delete();

        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil dihapus!');
    }

    /**
     * Opsi dikirim sebagai array (satu input per pilihan jawaban),
     * dibersihkan dari baris kosong dan duplikasi spasi.
     */
    private function validatePoll(Request $request): array
    {
        return $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'opsi' => 'required|array',
            'opsi.*' => 'nullable|string|max:150',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'opsi.required' => 'Minimal harus ada 2 pilihan jawaban.',
        ]);
    }

    /**
     * Buang baris kosong (hasil klik +/- di form) dan rapikan spasi.
     * Disimpan lagi ke $request agar aturan "minimal 2 opsi" tervalidasi
     * dari data yang benar-benar terisi.
     */
    private function cleanOptions(array $opsi): array
    {
        $opsi = array_values(array_filter(array_map(
            fn ($teks) => trim((string) $teks),
            $opsi
        ), fn ($teks) => $teks !== ''));

        if (count($opsi) < 2) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'opsi' => 'Minimal harus ada 2 pilihan jawaban yang terisi.',
            ]);
        }

        return $opsi;
    }

    private function syncOptions(Poll $poll, array $opsi): void
    {
        foreach ($opsi as $index => $teks) {
            PollOption::create([
                'poll_id' => $poll->id,
                'opsi' => $teks,
                'suara' => 0,
                'urutan' => $index + 1,
            ]);
        }
    }

    /**
     * Pasangkan opsi_id[] (kosong untuk baris pilihan baru) dengan opsi[]
     * berdasarkan urutan input pada form edit, lalu buang baris yang
     * teksnya dikosongkan pengguna.
     */
    private function cleanOptionsForUpdate(array $teksOpsi, array $idOpsi): array
    {
        $opsi = [];

        foreach ($teksOpsi as $index => $teks) {
            $teks = trim((string) $teks);

            if ($teks === '') {
                continue;
            }

            $opsi[] = [
                'id' => $idOpsi[$index] ?? null,
                'teks' => $teks,
            ];
        }

        if (count($opsi) < 2) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'opsi' => 'Minimal harus ada 2 pilihan jawaban yang terisi.',
            ]);
        }

        return $opsi;
    }

    /**
     * Perbarui pilihan yang sudah ada (jumlah suara tetap tersimpan),
     * buat pilihan baru yang ditambahkan lewat form edit, dan hapus
     * pilihan lama yang sudah tidak disertakan lagi.
     */
    private function syncOptionsOnUpdate(Poll $poll, array $opsi): void
    {
        $idDipertahankan = [];

        foreach ($opsi as $index => $data) {
            $urutan = $index + 1;
            $option = $data['id'] ? $poll->options()->whereKey($data['id'])->first() : null;

            if ($option) {
                $option->update(['opsi' => $data['teks'], 'urutan' => $urutan]);
            } else {
                $option = PollOption::create([
                    'poll_id' => $poll->id,
                    'opsi' => $data['teks'],
                    'suara' => 0,
                    'urutan' => $urutan,
                ]);
            }

            $idDipertahankan[] = $option->id;
        }

        $poll->options()->whereNotIn('id', $idDipertahankan)->delete();
    }
}
