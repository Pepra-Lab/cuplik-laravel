<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;

class CategoryPaginationTest extends TestCase
{
    public function test_home_page_paginates_categories(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Lihat Kategori Lainnya');
    }

    public function test_home_page_ajax_returns_json(): void
    {
        $response = $this->getJson('/?page=2');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'html',
            'hasMore',
            'nextUrl',
            'currentPage',
            'lastPage'
        ]);
        $this->assertEquals(2, $response->json('currentPage'));
    }
}
