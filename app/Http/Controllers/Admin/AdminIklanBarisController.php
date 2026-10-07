<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IklanBaris;

class AdminIklanBarisController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = IklanBaris::query();

        if ($status) {
            $query->where('status', $status);
        }

        $iklans = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('admin.iklan.baris', compact('iklans', 'status'));
    }

    public function updateStatus(Request $request, IklanBaris $iklanBari)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        $iklanBari->update(['status' => $request->status]);

        return back()->with('success', 'Status iklan baris berhasil diubah menjadi ' . $request->status);
    }

    public function destroy(IklanBaris $iklanBari)
    {
        $iklanBari->delete();
        return back()->with('success', 'Iklan baris berhasil dihapus!');
    }
}
