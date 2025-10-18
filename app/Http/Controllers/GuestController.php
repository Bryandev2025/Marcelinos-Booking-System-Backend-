<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{

    public function index()
    {
        $guest = Guest::all();

        return response()->json($guest);
    }


     public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:guests,email',
            'address' => 'required|string|max:255',
        ]);

        $guest = Guest::create($validated);

        return response()->json([
            'message' => 'Guest successfully created!',
            'data' => $guest
        ], 201);
    }
}
