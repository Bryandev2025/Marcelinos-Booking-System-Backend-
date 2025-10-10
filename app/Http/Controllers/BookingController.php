<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $bookings = Booking::with(['guest', 'room'])->get();
        return response()->json($bookings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'num_of_guests' => 'required|integer|min:1',
            'total_price' => 'required|integer|min:0',
        ]);

        $validated['reference_id'] = Str::uuid();
        $validated['payment_status'] = 'Unpaid';
        $validated['status'] = 'Pending';

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created successfully!',
            'data' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    return response()->json(['booking' => $booking]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|in:Pending,Confirmed,Checked-In,Completed,Cancelled,Rescheduled',
            'payment_status' => 'sometimes|in:Unpaid,Paid,Refunded',
            'remarks' => 'nullable|string',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully!',
            'data' => $booking
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully!']);
    }
}
