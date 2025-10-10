<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json(Room::all());
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
            'room_number' => 'required|string|unique:rooms,room_number',
            'type' => 'required|in:Standard,Deluxe,Family',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'status' => 'in:Available,Occupied,Maintenance',
            'description' => 'nullable|string',
        ]);

        $room = Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully!',
            'data' => $room
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $room = Room::findOrFail($id);
        return response()->json($room);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_number' => 'sometimes|string|unique:rooms,room_number,' . $id,
            'type' => 'sometimes|in:Standard,Deluxe,Family',
            'capacity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:Available,Occupied,Maintenance',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);

        return response()->json([
            'message' => 'Room updated successfully!',
            'data' => $room
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(['message' => 'Room deleted successfully!']);
    }
}
