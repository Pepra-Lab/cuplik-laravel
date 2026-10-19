<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BeritaFormTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Article::where('slug', 'like', 'pemerintah-umumkan-kenaikan-harga-bbm%')->delete();
    }
    public function test_concise_slug_generation_removes_stopwords_and_limits_words(): void
    {
        $title = "Pemerintah Resmi Umumkan Kenaikan Harga BBM Mulai Besok";
        $slug = Article::generateConciseSlug($title);
        $this->assertEquals("pemerintah-umumkan-kenaikan-harga-bbm", $slug);
    }

    public function test_slug_uniqueness_appends_numbered_suffix(): void
    {
        $category = Category::firstOrCreate(['nama' => 'Nasional'], ['slug' => 'nasional']);
        
        $base = "pemerintah-umumkan-kenaikan-harga-bbm";
        // Create an existing article with this slug
        $art1 = Article::create([
            'judul' => 'Test 1',
            'slug' => $base,
            'category_id' => $category->id,
            'isi' => '<p>Paragraf pertama isi berita.</p>',
            'status' => 'Terbit',
            'tanggal' => now(),
        ]);

        $uniqueSlug = Article::generateUniqueSlug($base);
        $this->assertEquals("{$base}-2", $uniqueSlug);

        // If -2 also exists
        $art2 = Article::create([
            'judul' => 'Test 2',
            'slug' => "{$base}-2",
            'category_id' => $category->id,
            'isi' => '<p>Paragraf kedua isi berita.</p>',
            'status' => 'Terbit',
            'tanggal' => now(),
        ]);

        $uniqueSlug3 = Article::generateUniqueSlug($base);
        $this->assertEquals("{$base}-3", $uniqueSlug3);

        // Clean up
        $art1->delete();
        $art2->delete();
    }

    public function test_lead_generation_extracts_first_paragraph_and_truncates(): void
    {
        $html = '<p>Ini adalah <strong>paragraf pertama</strong> yang sangat penting bagi pembaca berita.</p><p>Ini paragraf kedua.</p>';
        $lead = Article::generateLead($html, 500);
        $this->assertEquals('Ini adalah paragraf pertama yang sangat penting bagi pembaca berita.', $lead);

        // Long paragraph > 500 chars
        $longParagraph = '<p>' . str_repeat('kata ', 120) . 'terakhir.</p><p>Paragraf dua.</p>';
        $leadLong = Article::generateLead($longParagraph, 500);
        $this->assertLessThanOrEqual(503, mb_strlen($leadLong)); // 500 + '...'
        $this->assertStringEndsWith('...', $leadLong);
        $this->assertStringNotContainsString('<p>', $leadLong);
    }

    public function test_render_content_with_images_inlines_after_chosen_paragraph(): void
    {
        $category = Category::firstOrCreate(['nama' => 'Ekonomi'], ['slug' => 'ekonomi']);

        $article = new Article([
            'judul' => 'Uji Coba Gambar',
            'slug' => 'uji-coba-gambar',
            'category_id' => $category->id,
            'isi' => '<p>Paragraf satu berita.</p><p>Paragraf dua berita.</p><p>Paragraf tiga berita.</p>',
            'foto' => 'storage/berita/sample1.webp',
            'foto_posisi' => 'header',
            'foto_2' => 'storage/berita/sample2.webp',
            'foto_2_posisi' => 'p2',
            'caption_foto_2' => 'Grafik Pertumbuhan Ekonomi',
            'status' => 'Terbit',
            'tanggal' => now(),
        ]);

        $rendered = $article->renderContentWithImages();
        // Since foto_posisi is header, foto 1 is not inside body
        $this->assertStringNotContainsString('sample1.webp', $rendered);
        // foto 2 is at p2, should be after Paragraf dua
        $this->assertStringContainsString('sample2.webp', $rendered);
        $this->assertStringContainsString('Grafik Pertumbuhan Ekonomi', $rendered);

        // Check it comes after paragraph 2 and before paragraph 3
        $posP2 = strpos($rendered, 'Paragraf dua');
        $posImg = strpos($rendered, 'sample2.webp');
        $posP3 = strpos($rendered, 'Paragraf tiga');

        $this->assertTrue($posP2 < $posImg && $posImg < $posP3);
    }

    public function test_admin_article_store_and_tag_creation(): void
    {
        Storage::fake('public');

        $user = User::firstOrCreate(['email' => 'admin_test@cuplik.com'], [
            'name' => 'Admin Tester',
            'password' => bcrypt('secret123'),
            'role' => 'Super Admin',
            'status' => 'Aktif',
        ]);
        $user->update(['status' => 'Aktif', 'role' => 'Super Admin']);

        $category = Category::firstOrCreate(['nama' => 'Politik'], ['slug' => 'politik']);
        $existingTag = Tag::firstOrCreate(['nama' => 'Pemilu'], ['slug' => 'pemilu', 'category_id' => $category->id]);

        $imageFile1 = UploadedFile::fake()->image('gambar1.jpg', 600, 400);
        $imageFile2 = UploadedFile::fake()->image('gambar2.webp', 600, 400);

        $response = $this->actingAs($user)->post(route('admin.articles.store'), [
            'judul' => 'Pemerintah Resmi Umumkan Kenaikan Harga BBM Mulai Besok',
            'slug' => '', // Dikosongkan agar dibuat otomatis
            'category_id' => $category->id,
            'penulis_nama' => 'Jurnalis Investigasi',
            'lokasi' => 'JAKARTA',
            'isi' => '<p>Pemerintah secara resmi mengumumkan kebijakan penyesuaian tarif BBM bersubsidi.</p><p>Kebijakan ini diambil setelah melalui serangkaian kajian mendalam.</p>',
            'gambar_1' => $imageFile1,
            'gambar_2' => $imageFile2,
            'foto_posisi' => 'header',
            'foto_2_posisi' => 'p1',
            'caption_foto' => 'Konferensi Pers Pemerintah',
            'caption_foto_2' => 'Grafik Harga Minyak Dunia',
            'status' => 'Terbit',
            'tanggal' => '2026-10-12T10:00',
            'tags' => [$existingTag->id],
            'custom_tags' => ['IKN Nusantara', 'pemilu'], // Notice 'pemilu' is lower-case duplicate of existing
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article = Article::where('slug', 'pemerintah-umumkan-kenaikan-harga-bbm')->first();
        $this->assertNotNull($article, 'Article with concise slug must exist');
        $this->assertEquals('pemerintah-umumkan-kenaikan-harga-bbm', $article->slug);
        $this->assertEquals('Pemerintah secara resmi mengumumkan kebijakan penyesuaian tarif BBM bersubsidi.', $article->lead);

        $this->assertNotNull($article->foto);
        $this->assertNotNull($article->foto_2);
        $this->assertEquals('header', $article->foto_posisi);
        $this->assertEquals('p1', $article->foto_2_posisi);

        // Verify tags attached
        $tags = $article->tags;
        $tagNames = $tags->pluck('nama')->toArray();
        $this->assertContains('Pemilu', $tagNames);
        $this->assertContains('IKN Nusantara', $tagNames);

        // Verify master tag table didn't duplicate 'pemilu'
        $pemiluCount = Tag::whereRaw('LOWER(nama) = ?', ['pemilu'])->count();
        $this->assertEquals(1, $pemiluCount, 'Tag Pemilu must not be duplicated case-insensitively');

        // Test update: edit slug manually, update content, delete image 2
        $updateResponse = $this->actingAs($user)->put(route('admin.articles.update', $article), [
            'judul' => 'Pemerintah Mengumumkan Penyesuaian Harga BBM',
            'slug' => 'kebijakan-bbm-terbaru-2026', // Manual slug edit
            'category_id' => $category->id,
            'isi' => '<p>Paragraf baru yang telah diedit oleh redaktur.</p><p>Paragraf kedua.</p>',
            'foto_posisi' => 'p1',
            'hapus_gambar_2' => 1,
            'status' => 'Terbit',
            'tanggal' => '2026-10-12T11:00',
            'tags' => [$existingTag->id],
        ]);

        $updateResponse->assertRedirect(route('admin.articles.index'));
        $article->refresh();

        $this->assertEquals('kebijakan-bbm-terbaru-2026', $article->slug);
        $this->assertEquals('Paragraf baru yang telah diedit oleh redaktur.', $article->lead);
        $this->assertNull($article->foto_2);
        $this->assertEquals('p1', $article->foto_posisi);

        // Clean up
        $article->tags()->detach();
        $article->delete();
        Tag::where('nama', 'IKN Nusantara')->delete();
    }
}
