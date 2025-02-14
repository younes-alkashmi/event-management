<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
});

Route::middleware(['auth:sanctum', 'role:admin,manager'])->group(function () {
    Route::apiResource('events', EventController::class);
});

Route::middleware(['auth:sanctum', 'role:basic'])->group( function() {
    Route::apiResource('events.tickets', TicketController::class);
    Route::post('/tickets/{ticketId}/share', [TicketController::class, 'transfer']);
});

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
