<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
});

Route::middleware(['auth:sanctum', 'role:admin,manager'])->group(function () {
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:basic'])->group(function () {
    Route::apiResource('events.tickets', TicketController::class);
    Route::post('/tickets/{ticketId}/share', [TicketController::class, 'transfer']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::post('logout', [AuthController::class, 'logout']);
});
