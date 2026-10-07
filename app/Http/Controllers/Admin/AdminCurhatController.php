<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curhat;

class AdminCurhatController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = trim($request->query('q', ''));

        $query = Curhat::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('pesan', 'ilike', "%{$q}%")
                    ->orWhere('pengirim', 'ilike', "%{$q}%")
                    ->orWhere('lokasi', 'ilike', "%{$q}%");
            });
        }

        $curhats = $query->latest('created_at')->paginate(15)->withQueryString();

        return view('admin.curhats.index', compact('curhats', 'status', 'q'));
    }

    public function updateStatus(Request $request, Curhat $curhat)
    {
        $request->validate([
            'status' => 'required|in:Baru,Tampil,Disembunyikan',
        ]);

        $curhat->update(['status' => $request->status]);

        return back()->with('success', 'Status keluh kesah berhasil diubah menjadi ' . $request->status);
    }

    public function destroy(Curhat $curhat)
    {
        $curhat->delete();
        return back()->with('success', 'Keluh kesah berhasil dihapus!');
    }
}
