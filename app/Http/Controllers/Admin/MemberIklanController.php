<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IklanBaris;
use App\Models\IklanGambar;
use App\Models\IklanPosisi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberIklanController extends Controller
{
    private const KATEGORI_TEKS = ['Jual Beli', 'Properti', 'Kendaraan', 'Lowongan'];

    public function index(Request $request): View
    {
        $tab = $request->query('tab') === 'teks' ? 'teks' : 'gambar';
        $query = $tab === 'teks' ? IklanBaris::query() : IklanGambar::query();

        return view('admin.member.iklan', [
            'tab' => $tab,
            'iklans' => $query->visibleTo($request->user())->latest()->paginate(10)->withQueryString(),
            'posisis' => IklanPosisi::orderBy('nama')->get(),
            'kategoriTeks' => self::KATEGORI_TEKS,
        ]);
    }

    public function storeGambar(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'posisi' => 'required|exists:iklan_posisis,nama',
            'link' => 'nullable|url|max:255',
            'gambar' => 'required|image|max:2048',
            'mulai' => 'required|date|after_or_equal:today',
            'selesai' => 'required|date|after_or_equal:mulai',
        ]);

        IklanGambar::create([
            ...Arr::except($data, 'gambar'),
            'user_id' => $request->user()->id,
            'ukuran' => IklanPosisi::where('nama', $data['posisi'])->value('ukuran'),
            'gambar' => 'storage/'.$request->file('gambar')->store('iklan', 'public'),
            'status' => 'Menunggu',
        ]);

        return redirect()->route('admin.iklan-saya.index', ['tab' => 'gambar'])
            ->with('success', 'Iklan gambar terkirim dan menunggu validasi admin.');
    }

    public function storeBaris(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kategori' => ['required', Rule::in(self::KATEGORI_TEKS)],
            'isi' => 'required|string|min:10|max:500',
        ]);

        IklanBaris::create([
            ...$data,
            'user_id' => $request->user()->id,
            'pemasang' => $request->user()->name,
            'tanggal' => now()->toDateString(),
            'status' => 'Menunggu',
        ]);

        return redirect()->route('admin.iklan-saya.index', ['tab' => 'teks'])
            ->with('success', 'Iklan teks terkirim dan menunggu validasi admin.');
    }

    public function destroyGambar(IklanGambar $iklanGambar): RedirectResponse
    {
        $this->ensureWithdrawable($iklanGambar);

        Storage::disk('public')->delete(Str::after($iklanGambar->gambar, 'storage/'));
        $iklanGambar->delete();

        return back()->with('success', 'Iklan gambar dibatalkan.');
    }

    public function destroyBaris(IklanBaris $iklanBari): RedirectResponse
    {
        $this->ensureWithdrawable($iklanBari);

        $iklanBari->delete();

        return back()->with('success', 'Iklan teks dibatalkan.');
    }

    /**
     * Member hanya boleh membatalkan iklannya sendiri yang belum divalidasi.
     */
    private function ensureWithdrawable(Model $iklan): void
    {
        abort_unless($iklan->user_id === auth()->id() && $iklan->status === 'Menunggu', 403);
    }
}
