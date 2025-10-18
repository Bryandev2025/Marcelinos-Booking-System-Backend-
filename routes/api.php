<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




// Guests
Route::get('/guests', [GuestController::class, 'index']);
Route::post('/guests', [GuestController::class, 'store']);



// ----------------- Rooms -----------------
Route::get('/rooms', [RoomController::class, 'index']);       // List all rooms
Route::get('/rooms/{id}', [RoomController::class, 'show']);   // Get single room
Route::post('/rooms', [RoomController::class, 'store']);      // Create a room
Route::put('/rooms/{id}', [RoomController::class, 'update']); // Update a room
Route::delete('/rooms/{id}', [RoomController::class, 'destroy']); // Delete a room




// Bookings
Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/bookings/{id}', [BookingController::class, 'show']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::put('/bookings/{id}', [BookingController::class, 'update']);
Route::put('/bookings/{id}/pay', [BookingController::class, 'simulatePayment']);


