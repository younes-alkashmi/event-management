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
            'quantity' => 3,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tickets', ['quantity' => 3]);
    }

    /** @test */
    public function user_can_share_tickets()
    {
        $user = User::factory()->create(['role' => 'basic']);
        $sharedUser1 = User::factory()->create(['role' => 'basic']);
        $sharedUser2 = User::factory()->create(['role' => 'basic']);
        $this->actingAs($user);
        $ticket = Ticket::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson("/api/tickets/{$ticket->id}/share", [
            'user_ids' => [$sharedUser1->id, $sharedUser2->id],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_transfers', ['ticket_id' => $ticket->id]);
    }
}
