<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{



 // Create a new booking with 30-second pending expiration
    public function store(Request $request)
{
    $validated = $request->validate([
        'guest_id'      => 'required|exists:guests,id',
        'room_id'       => 'required|exists:rooms,id',
        'check_in'      => 'required|date|after_or_equal:today',
        'check_out'     => 'required|date|after:check_in',
        'num_of_guests' => 'required|integer|min:1',
    ]);

    $room = Room::findOrFail($validated['room_id']);

    $check_in = Carbon::parse($validated['check_in']);
    $check_out = Carbon::parse($validated['check_out']);

    // Prevent duplicate booking by same guest
    $duplicateBooking = Booking::where('room_id', $room->id)
        ->where('guest_id', $validated['guest_id'])
        ->whereIn('status', ['Pending', 'Confirmed'])
        ->where(function ($q) use ($check_in, $check_out) {
            $q->whereBetween('check_in', [$check_in, $check_out])
              ->orWhereBetween('check_out', [$check_in, $check_out])
              ->orWhere(function ($sub) use ($check_in, $check_out) {
                  $sub->where('check_in', '<=', $check_in)
                      ->where('check_out', '>=', $check_out);
              });
        })
        ->exists();

    if ($duplicateBooking) {
        return response()->json([
            'message' => 'You already have a booking for this room during these dates.'
        ], 400);
    }

    // Check if the room is already booked by others
    $overlap = Booking::where('room_id', $room->id)
        ->whereIn('status', ['Confirmed', 'Checked_In', 'Pending'])
        ->where(function ($q) use ($check_in, $check_out) {
            $q->whereBetween('check_in', [$check_in, $check_out])
              ->orWhereBetween('check_out', [$check_in, $check_out])
              ->orWhere(function ($sub) use ($check_in, $check_out) {
                  $sub->where('check_in', '<=', $check_in)
                      ->where('check_out', '>=', $check_out);
              });
        })
        ->exists();

    if ($overlap) {
        return response()->json([
            'message' => 'Room is already booked for the selected dates by another guest.'
        ], 400);
    }

    // Pending expiration after 30 seconds
    $pendingExpiresAt = now()->addSeconds(30);

    // Total price calculated based on frontend-provided stay duration
    $totalDays = $check_in->diffInDays($check_out);
    $totalPrice = $totalDays * $room->price;

    // Create booking
    $booking = Booking::create([
        'guest_id' => $validated['guest_id'],
        'room_id' => $room->id,
        'reference_id' => strtoupper(Str::random(8)),
        'check_in' => $check_in,
        'check_out' => $check_out,
        'num_of_guests' => $validated['num_of_guests'],
        'total_price' => $totalPrice,
        'status' => 'Pending',
        'payment_status' => 'Unpaid',
        'pending_expires_at' => $pendingExpiresAt,
    ]);

    // Immediately mark room as Reserved
    $room->update(['status' => 'Reserved']);

    return response()->json([
        'message' => 'Booking created successfully. You have 30 seconds to pay.',
        'booking' => $booking
    ], 201);
}

















   // Simulate payment
    public function simulatePayment($id)
    {
        $booking = Booking::with('room')->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found.'], 404);
        }

        // Check if booking expired
        if ($booking->status === 'Pending' && $booking->pending_expires_at < now()) {
            $booking->room->update(['status' => 'Available']);
            $booking->delete();
            return response()->json(['message' => 'Booking expired. Please create a new booking.'], 400);
        }

        if ($booking->payment_status === 'Paid') {
            return response()->json(['message' => 'This booking has already been paid.'], 400);
        }

        if (in_array($booking->status, ['Cancelled', 'Completed'])) {
            return response()->json(['message' => 'Cannot process payment for this booking.'], 400);
        }

        if ($booking->status !== 'Pending') {
            return response()->json(['message' => 'Booking is no longer pending.'], 400);
        }

        // Payment success
        $booking->update([
            'payment_status' => 'Paid',
            'status' => 'Confirmed',
        ]);

        $booking->room->update(['status' => 'Reserved']);

        return response()->json([
            'message' => 'Payment successful. Booking confirmed and room reserved.',
            'booking' => $booking
        ]);
    }











    

    // Update booking status and room status
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'nullable|in:Reserved,Checked_In,Completed,Cancelled',
            'payment_status' => 'nullable|in:Unpaid,Paid,Refunded',
            'remarks' => 'nullable|string',
        ]);

        $booking->update($validated);

        // Auto-update room status based on booking status
        if (isset($validated['status'])) {
            switch ($validated['status']) {
                case 'Reserved':
                    $booking->room->update(['status' => 'Reserved']);
                    break;
                case 'Checked_In':
                    $booking->room->update(['status' => 'Occupied']);
                    break;
                case 'Completed':
                case 'Cancelled':
                    $booking->room->update(['status' => 'Available']);
                    break;
            }
        }

        return response()->json([
            'message' => 'Booking and room status updated successfully.',
            'booking' => $booking
        ]);
    }

    // List all bookings
    public function index()
    {
        $bookings = Booking::with(['guest', 'room'])->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'List currently empty!']);
        }

        return response()->json($bookings, 200);
    }

    // Show single booking
    public function show($id)
    {
        $booking = Booking::with(['guest', 'room'])->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found.'], 404);
        }

        return response()->json($booking);
    }
}
