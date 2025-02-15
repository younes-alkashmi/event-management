<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\TicketTransfer;
use App\Jobs\TransferTicket;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    public function index($eventId) {
        $tickets = Ticket::where('event_id', $eventId)->get();

        return response()->json($tickets);
    }

    public function store(Request $request, $eventId) {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($eventId);
        $totalTicketsPurchased = Ticket::where('event_id', $eventId)
            ->sum('quantity');

        if ($totalTicketsPurchased + $validated['quantity'] > $event->max_tickets) {
            return response()->json(['error' => 'Not enough tickets available'], 400);
        }

        $fullPrice = $event->price * $validated['quantity'];
        $ticket = Ticket::create([
            'event_id' => $eventId,
            'user_id' => auth()->id(),
            'full_price' => $fullPrice,
            'quantity' => $validated['quantity'],
        ]);

        return response()->json($ticket, 201);
    }

    public function transfer(Request $request, $ticketId)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $currentUserId = auth()->id();
        if (in_array($currentUserId, $validated['user_ids'])) {
            throw ValidationException::withMessages([
                'user_ids' => ['The selected user IDs must not include the current user.'],
            ]);
        }

        $ticket = Ticket::findOrFail($ticketId);

        $totalTicketsPurchased = Ticket::where('user_id', $currentUserId)
            ->where('event_id', $ticket->event_id)
            ->sum('quantity');

        $ticketsToShare = count($validated['user_ids']);
        $ticketsTransferred = $ticket->transfers()->count();
        $availableForSharing = $totalTicketsPurchased - $ticketsTransferred;

        if ($availableForSharing - $ticketsToShare < 1) {
            return response()->json(['error' => 'You must retain at least one ticket for yourself.'], 400);
        }

        TransferTicket::dispatch($ticketId, $validated['user_ids']);

        return response()->json(['message' => 'Ticket shared successfully'], 200);
    }

    public function show($eventId, $ticketId) {
        $ticket = Ticket::where('event_id', $eventId)->findOrFail($ticketId);

        return response()->json($ticket);
    }

    public function destroy($eventId, $ticketId) {
        $userId = auth()->id();
        $ticket = Ticket::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->findOrFail($ticketId);

        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully'], status: 200);
    }
}
