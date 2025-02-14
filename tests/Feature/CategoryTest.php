<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_category()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->postJson('/api/categories', ['name' => 'Concerts']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'Concerts']);
    }

    /** @test */
    public function admin_can_get_all_categories()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        Category::factory()->create(['name' => 'Concerts']);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Concerts']);
    }
}
