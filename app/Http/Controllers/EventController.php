<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request) {
        $query = Event::query();
    
        // Filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
    
        if ($request->has('status')) {
            $currentDate = now();        
            $query->when($request->status === 'upcoming', function ($q) use ($currentDate) {
                return $q->where('date', '>', $currentDate);
            })
            ->when($request->status === 'past', function ($q) use ($currentDate) {
                return $q->where('date', '<=', $currentDate);
            })
            ->when($request->status === 'ongoing', function ($q) use ($currentDate) {
                return $q->whereDate('date', '=', $currentDate->toDateString());
            });
        }
    
        return response()->json($query->get());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'price' => 'required|numeric',
            'max_tickets' => 'required|integer|min:1',
        ]);

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    public function show($id) {
        $event = Event::findOrFail($id);

        return response()->json($event);
    }

    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'date' => 'sometimes|required|date',
            'price' => 'sometimes|numeric',
            'max_tickets' => 'sometimes|integer|min:1',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function destroy($id) {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}
