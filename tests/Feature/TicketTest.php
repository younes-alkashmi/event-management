<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Category;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_purchase_tickets()
    {
        $user = User::factory()->create(['role' => 'basic']);
        $this->actingAs($user);
        $category = Category::factory()->create();
        $event = Event::factory()->create(['max_tickets' => 10]);

        $response = $this->postJson("/api/events/{$event->id}/tickets", [
            'user_id' => $user->id,
            'price' => 49.99,
            'quantity' => 2,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tickets', ['quantity' => 2]);
    }

    /** @test */
    public function user_can_share_tickets()
    {
        $user = User::factory()->create(['role' => 'basic']);
        $this->actingAs($user);
        $category = Category::factory()->create();
        $event = Event::factory()->create(['max_tickets' => 10]);
        $ticket = Ticket::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

        $response = $this->postJson("/api/tickets/{$ticket->id}/share", [
            'new_user_ids' => [2, 3],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_transfers', ['ticket_id' => $ticket->id]);
    }
}
