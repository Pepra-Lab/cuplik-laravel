<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;

class AdminTagTest extends TestCase
{
    protected function getAdminUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'redaksi@cuplik.com'],
            [
                'name' => 'Ali Ma\'nawi',
                'password' => bcrypt('password'),
                'role' => 'Super Admin',
                'status' => 'Aktif',
            ]
        );
    }

    public function test_tag_index_page_loads_without_categories_and_sub(): void
    {
        $user = $this->getAdminUser();

        $response = $this->actingAs($user)->get(route('admin.tags.index'));
        $response->assertStatus(200);
        $response->assertSee('Tag Berita');
        $response->assertSee('Tambah Tag Baru');
        $response->assertDontSee('Kategori Induk');
        $response->assertDontSee('Tampilkan di Sub-Menu Navigasi');
    }

    public function test_can_create_tag_without_category_and_sub(): void
    {
        $user = $this->getAdminUser();

        $tagName = 'Tag Test Unik ' . time();
        $response = $this->actingAs($user)->post(route('admin.tags.store'), [
            'nama' => $tagName,
            'slug' => '',
        ]);

        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseHas('tags', [
            'nama' => $tagName,
        ]);
    }

    public function test_can_update_tag(): void
    {
        $user = $this->getAdminUser();

        $tag = Tag::create([
            'nama' => 'Tag To Update ' . time(),
            'slug' => 'tag-to-update-' . time(),
        ]);

        $response = $this->actingAs($user)->put(route('admin.tags.update', $tag), [
            'nama' => 'Tag Updated ' . time(),
            'slug' => 'tag-updated-' . time(),
        ]);

        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'nama' => 'Tag Updated ' . time(),
        ]);
    }
}
