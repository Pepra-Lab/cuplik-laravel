<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;

class AdminPollController extends Controller
{
    public function index()
    {
        $polls = Poll::with('options')->latest()->paginate(10);
        return view('admin.polls.index', compact('polls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'opsi' => 'required|string', // textarea lines
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->status === 'Aktif') {
            Poll::where('status', 'Aktif')->update(['status' => 'Nonaktif']);
        }

        $poll = Poll::create([
            'pertanyaan' => $request->pertanyaan,
            'status' => $request->status,
        ]);

        $options = array_filter(array_map('trim', explode("\n", $request->opsi)));
        foreach ($options as $index => $opt) {
            PollOption::create([
                'poll_id' => $poll->id,
                'opsi' => $opt,
                'suara' => 0,
                'urutan' => $index + 1,
            ]);
        }

        return redirect()->route('admin.polls.index')->with('success', 'Polling baru berhasil dibuat!');
    }

    public function update(Request $request, Poll $poll)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->status === 'Aktif') {
            Poll::where('id', '!=', $poll->id)->where('status', 'Aktif')->update(['status' => 'Nonaktif']);
        }

        $poll->update([
            'pertanyaan' => $request->pertanyaan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil diperbarui!');
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('admin.polls.index')->with('success', 'Polling berhasil dihapus!');
    }
}
