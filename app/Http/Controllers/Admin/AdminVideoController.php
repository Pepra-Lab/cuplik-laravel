<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Models\Video;

class AdminVideoController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Video::class);

        $q = trim($request->query('q', ''));
        $status = $request->query('status');

        $query = Video::visibleTo($request->user());

        if ($q !== '') {
            $query->where('judul', 'ilike', "%{$q}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $videos = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('admin.videos.index', compact('videos', 'q', 'status'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Video::class);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url',
            'durasi' => 'nullable|string|max:20',
            'tanggal' => 'required|date',
            'status' => 'required|in:Tayang,Draft',
        ]);

        $baseSlug = Str::slug($validated['judul']);
        $slug = $baseSlug;
        $counter = 1;
        while (Video::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $validated['slug'] = $slug;
        $validated['user_id'] = $request->user()->id;

        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan!');
    }

    public function update(Request $request, Video $video)
    {
        Gate::authorize('update', $video);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url',
            'durasi' => 'nullable|string|max:20',
            'tanggal' => 'required|date',
            'status' => 'required|in:Tayang,Draft',
        ]);

        if ($video->judul !== $validated['judul']) {
            $baseSlug = Str::slug($validated['judul']);
            $slug = $baseSlug;
            $counter = 1;
            while (Video::where('slug', $slug)->where('id', '!=', $video->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui!');
    }

    public function destroy(Video $video)
    {
        Gate::authorize('delete', $video);

        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus!');
    }
}
