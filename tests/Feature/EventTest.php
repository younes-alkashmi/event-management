<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $category = Category::factory()->create();

        $response = $this->postJson('/api/events', [
            'name' => 'Music Festival',
            'description' => 'A great music festival',
            'category_id' => $category->id,
            'date' => '2023-12-31T20:00:00',
            'max_tickets' => 1000,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', ['name' => 'Music Festival']);
    }

    /** @test */
    public function admin_can_get_all_events()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        Event::factory()->create(['name' => 'Music Festival']);

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Music Festival']);
    }
}
