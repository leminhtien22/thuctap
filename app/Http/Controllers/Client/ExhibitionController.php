<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BookingTicket;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExhibitionController extends Controller
{
    public function index()
    {
        $data = Exhibition::where('status', 'active')
            ->get();

        return view('client.exhibition.view', compact('data'));
    }

    public function details($id)
    {
        $data = Exhibition::findOrFail($id);

        if ($data->getIsInactiveAttribute()) {
            abort(404);
        }

        return view('client.exhibition.details', compact('data'));
    }

    public function showBooking($id)
    {
        $data = Exhibition::findOrFail($id);
        return view('client.exhibition.booking-ticket', compact('data'));
    }

    public function booking(Request $request, $id)
    {
        $request->validate([
            'details' => 'nullable|string|max:255',
            'ticket_count' => 'required|integer|min:1'
        ]);

        // Found exhibition
        $exhibition = Exhibition::findOrFail($id);

        // Check if exhibition is active
        if ($exhibition->getIsInactiveAttribute()) {
            return redirect()->back()->withInput()->with('error', 'Buổi triển lãm không còn khả dụng!');
        }

        // Check if exhibition end date is greater than current date
        if ($exhibition->getIsExpiredAttribute()) {
            return redirect()->back()->withInput()->with('error', 'Buổi triển lãm đa hết thời hạn đặt vé!');
        }

        if ($exhibition->is_limited_tickets) {
            $available_tickets = $exhibition->getAvailableTicketsAttribute();

            if ($request->ticket_count > $available_tickets) {
                return redirect()->back()->withInput()->with('error', 'Số lượng vé không đủ! ' . 'Chỉ còn lại ' . $available_tickets . ' vé!');
            }
        }

        // Get current user logged
        $user = Auth::user();

        // Create booking ticket
        BookingTicket::create([
            'exhibition_id' => $id,
            'user_id' => $user->id,
            'ticket_count' => $request->ticket_count,
            'total_price' => $exhibition->price * $request->ticket_count,
            'details' => $request->details,
            'is_paid' =>  $exhibition->price <= 0 ? true : false
        ]);

        return redirect()->route('client.exhibition.ticket.history')->with('success', 'Đặt vé thành công!');
    }

    public function ticketHistory(Request $request)
    {

        $perPage = $request->input('limit', 10);

        $data = BookingTicket::where('user_id', Auth::user()->id)->paginate($perPage)->appends($request->query());
        return view('client.exhibition.ticket-history', compact('data'));
    }
}
