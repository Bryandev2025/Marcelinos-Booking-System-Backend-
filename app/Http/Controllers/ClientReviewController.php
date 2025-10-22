<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientReview;

class ClientReviewController extends Controller
{
    public function index()
        {
            $reviews = ClientReview::with('guest')->latest()->get();

            return response()->json($reviews);
        }
}
