<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\IklanGambar;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SecurityAndAuditTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Article::where('slug', 'draft-rahasia-test')->delete();
        IklanGambar::where('judul', 'like', '%Test Audit%')->delete();
    }

    public function test_guest_cannot_view_draft_article(): void
    {
        $category = Category::firstOrCreate(['slug' => 'nasional-test'], ['nama' => 'Nasional Test', 'urutan' => 1]);

        $draft = Article::create([
            'judul' => 'Draft Rahasia Test',
            'slug' => 'draft-rahasia-test',
            'category_id' => $category->id,
            'isi' => 'Konten rahasia belum terbit.',
            'status' => 'Draft',
            'tanggal' => now()->toDateString(),
        ]);

        // Guest visitor should receive 404
        $response = $this->get(route('article.show', $draft->slug));
        $response->assertNotFound();
    }

    public function test_cms_staff_can_preview_draft_article(): void
    {
        $category = Category::firstOrCreate(['slug' => 'nasional-test'], ['nama' => 'Nasional Test', 'urutan' => 1]);

        $admin = User::firstOrCreate(
            ['email' => 'admin_test_audit@cuplik.com'],
            ['name' => 'Admin Audit', 'password' => 'password123', 'role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE]
        );

        $draft = Article::create([
            'judul' => 'Draft Rahasia Test',
            'slug' => 'draft-rahasia-test',
            'category_id' => $category->id,
            'isi' => 'Konten rahasia belum terbit.',
            'status' => 'Draft',
            'tanggal' => now()->toDateString(),
        ]);

        // CMS staff should be able to preview
        $response = $this->actingAs($admin)->get(route('article.show', $draft->slug));
        $response->assertOk();
    }

    public function test_iklan_gambar_active_scope_filters_expired_and_future_dates(): void
    {
        // 1. Currently active ad
        $activeAd = IklanGambar::create([
            'judul' => 'Test Audit Active',
            'posisi' => 'Header 728x90',
            'status' => 'Tayang',
            'mulai' => now()->subDays(2)->toDateString(),
            'selesai' => now()->addDays(2)->toDateString(),
        ]);

        // 2. Expired ad
        $expiredAd = IklanGambar::create([
            'judul' => 'Test Audit Expired',
            'posisi' => 'Header 728x90',
            'status' => 'Tayang',
            'mulai' => now()->subDays(10)->toDateString(),
            'selesai' => now()->subDays(1)->toDateString(),
        ]);

        // 3. Future scheduled ad
        $futureAd = IklanGambar::create([
            'judul' => 'Test Audit Future',
            'posisi' => 'Header 728x90',
            'status' => 'Tayang',
            'mulai' => now()->addDays(2)->toDateString(),
            'selesai' => now()->addDays(10)->toDateString(),
        ]);

        $activeIds = IklanGambar::active()->pluck('id')->all();

        $this->assertContains($activeAd->id, $activeIds);
        $this->assertNotContains($expiredAd->id, $activeIds);
        $this->assertNotContains($futureAd->id, $activeIds);
    }

    public function test_robots_txt_returns_absolute_sitemap_url(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertOk();
        $response->assertSee('Sitemap: http');
    }

    public function test_custom_404_page_renders_with_portal_branding(): void
    {
        $response = $this->get('/halaman-yang-pasti-tidak-ada-12345');
        $response->assertNotFound();
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('Kembali ke Beranda');
    }
}
