<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminNewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::latest('tanggal');

        if ($request->filled('q')) {
            $query->where('email', 'like', '%' . $request->q . '%');
        }

        $subscribers = $query->paginate(15)->withQueryString();
        $setting = Setting::current();

        return view('admin.settings.newsletter', compact('subscribers', 'setting'));
    }

    public function destroy(NewsletterSubscriber $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('admin.newsletter.index')->with('success', 'Subscriber berhasil dihapus!');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::orderBy('email')->get();

        $filename = 'newsletter-subscribers-' . now()->format('Ymd-His') . '.csv';

        $callback = function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Tanggal Berlangganan']);
            foreach ($subscribers as $s) {
                fputcsv($handle, [$s->email, optional($s->tanggal)->format('Y-m-d')]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
