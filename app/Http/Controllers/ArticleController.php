<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\IklanGambar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::with(['category', 'tags', 'comments' => function ($q) {
            $q->where('status', 'Disetujui')->latest();
        }])
        ->where('slug', $slug)
        ->firstOrFail();

        // Lindungi berita yang masih Draft atau Review agar tidak bocor ke publik
        if ($article->status !== 'Terbit') {
            $user = auth()->user();
            $canPreview = $user && ($user->isCmsStaff() || $user->id === $article->user_id);
            if (! $canPreview) {
                abort(404);
            }
        }

        // Increment views count
        $article->increment('dibaca');

        // Related articles in same category
        $relatedArticles = Article::where('status', 'Terbit')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('tanggal')
            ->take(4)
            ->get();

        // Popular articles
        $popularArticles = Article::where('status', 'Terbit')
            ->orderByDesc('dibaca')
            ->take(5)
            ->get();

        // Trending tags
        $trendingTags = Tag::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(8)
            ->get();

        // Banner Ads (hanya yang aktif tayang sesuai rentang tanggal)
        $iklanSidebar = IklanGambar::active()->where('posisi', 'like', '%Sidebar%')->first();
        $iklanArtikel = IklanGambar::active()->where('posisi', 'like', '%Artikel%')->first();

        return view('frontend.article-detail', compact(
            'article',
            'relatedArticles',
            'popularArticles',
            'trendingTags',
            'iklanSidebar',
            'iklanArtikel'
        ));
    }

    public function storeComment(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        Comment::create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'komentar' => $request->komentar,
            'status' => 'Disetujui',
        ]);

        return back()->with('success', 'Komentar Anda berhasil dipublikasikan!');
    }

    public function downloadPdf(Request $request, string $slug)
    {
        $article = Article::with(['category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Lindungi berita yang belum terbit agar tidak dapat diunduh
        if ($article->status !== 'Terbit') {
            $user = auth()->user();
            $canPreview = $user && ($user->isCmsStaff() || $user->id === $article->user_id);
            if (! $canPreview) {
                abort(404);
            }
        }

        // Resolusi gambar header menjadi base64 agar Dompdf dapat merender tanpa kendala jaringan
        $headerImage = null;
        if ($article->foto && ($article->foto_posisi === 'header' || empty($article->foto_posisi))) {
            $headerImage = $this->resolveImageAsBase64($article->foto);
        } elseif ($article->foto_2 && $article->foto_2_posisi === 'header') {
            $headerImage = $this->resolveImageAsBase64($article->foto_2);
        }

        $headerImage2 = null;
        if ($article->foto && $article->foto_2 && $article->foto_2_posisi === 'header') {
            $headerImage2 = $this->resolveImageAsBase64($article->foto_2);
        }

        // Siapkan konten berita dengan resolusi gambar inline base64
        $processedContent = $this->prepareContentForPdf($article);

        $pdf = Pdf::loadView('pdf.article', [
            'article' => $article,
            'headerImage' => $headerImage,
            'headerImage2' => $headerImage2,
            'processedContent' => $processedContent,
            'downloadDate' => Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WIB',
            'articleUrl' => route('article.show', $article->slug),
        ]);

        $pdf->setPaper('a4', 'portrait');

        $filename = 'cuplik-' . Str::slug($article->slug) . '.pdf';

        if ($request->has('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    private function prepareContentForPdf(Article $article): string
    {
        $content = $article->renderContentWithImages();

        // Ganti src gambar lokal/eksternal di dalam tag img menjadi format data URI base64
        return preg_replace_callback('/<img\s+[^>]*src="([^"]+)"[^>]*>/i', function ($matches) {
            $imgTag = $matches[0];
            $src = $matches[1];
            $base64 = $this->resolveImageAsBase64($src);
            if ($base64) {
                return str_replace($src, $base64, $imgTag);
            }
            return $imgTag;
        }, $content);
    }

    private function resolveImageAsBase64(?string $path): ?string
    {
        if (!$path) return null;

        if (str_starts_with($path, 'data:image')) {
            return $path;
        }

        $cleanPath = ltrim(parse_url($path, PHP_URL_PATH) ?? '', '/');
        
        // Proteksi Path Traversal
        if (str_contains($cleanPath, '..')) {
            return null;
        }

        $candidates = [
            public_path($cleanPath),
            storage_path('app/public/' . preg_replace('#^storage/#', '', $cleanPath)),
            public_path('storage/' . preg_replace('#^storage/#', '', $cleanPath)),
        ];

        foreach ($candidates as $filePath) {
            if ($filePath && file_exists($filePath) && is_file($filePath)) {
                $mime = mime_content_type($filePath);
                // Hanya izinkan file yang benar-benar bertipe gambar (mencegah pembacaan .env atau file kode)
                if ($mime && str_starts_with($mime, 'image/')) {
                    $data = base64_encode(file_get_contents($filePath));
                    return 'data:' . $mime . ';base64,' . $data;
                }
            }
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            $host = parse_url($path, PHP_URL_HOST);
            // Proteksi SSRF: Jangan izinkan request ke IP private/internal/localhost
            $ip = $host ? gethostbyname($host) : null;
            if (!$ip || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                return null;
            }

            try {
                $response = Http::timeout(5)->get($path);
                if ($response->successful()) {
                    $mime = $response->header('Content-Type') ?: 'image/jpeg';
                    if (str_starts_with($mime, 'image/')) {
                        return 'data:' . $mime . ';base64,' . base64_encode($response->body());
                    }
                }
            } catch (\Throwable $e) {
                // Abaikan jika eksternal gagal
            }
        }

        return null;
    }
}
