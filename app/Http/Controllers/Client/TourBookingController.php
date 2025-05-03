<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TourBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourBookingController extends Controller
{
    public function create()
    {
        return view('client.tour.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'number_of_people' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to book a tour.');
        }

        $totalPrice = $request->number_of_people * 100000; // Giá 100.000 VNĐ/người cho tour riêng

        TourBooking::create([
            'user_id' => $user->id,
            'tour_type' => 'private',
            'booking_date' => $request->booking_date,
            'number_of_people' => $request->number_of_people,
            'total_price' => $totalPrice,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('tour.create')->with('success', 'Booking request submitted successfully! Please wait for confirmation.');
    }
}