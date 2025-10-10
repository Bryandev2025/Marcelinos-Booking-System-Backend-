<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Guest::all());
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
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|string',
            'email' => 'nullable|email|unique:guests,email',
            'address' => 'nullable|string',
        ]);

        $guest = Guest::create($validated);

        return response()->json([
            'message' => 'Guest added successfully!',
            'data' => $guest
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guest = Guest::findOrFail($id);
        return response()->json($guest);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guest $guest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $guest = Guest::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'sometimes|string',
            'gender' => 'sometimes|in:Male,Female,Other',
            'phone' => 'sometimes|string',
            'email' => 'nullable|email|unique:guests,email,' . $id,
            'address' => 'nullable|string',
        ]);

        $guest->update($validated);

        return response()->json([
            'message' => 'Guest updated successfully!',
            'data' => $guest
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $guest = Guest::findOrFail($id);
        $guest->delete();

        return response()->json(['message' => 'Guest deleted successfully!']);
    }
}
