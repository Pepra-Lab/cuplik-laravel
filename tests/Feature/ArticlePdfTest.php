<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Category;

class ArticlePdfTest extends TestCase
{
    public function test_can_download_article_pdf(): void
    {
        $article = Article::where('status', 'Terbit')->first();
        if (!$article) {
            $category = Category::firstOrCreate(['nama' => 'Nasional'], ['slug' => 'nasional']);
            $article = Article::create([
                'judul' => 'Judul Berita Testing PDF',
                'slug' => 'judul-berita-testing-pdf',
                'category_id' => $category->id,
                'isi' => '<p>Ini adalah isi berita pengujian PDF.</p>',
                'status' => 'Terbit',
                'tanggal' => now(),
            ]);
        }

        $response = $this->get(route('article.pdf', $article->slug));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
