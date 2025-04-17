<?php

namespace App\Http\Controllers;

use App\Models\BookingTicket;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingTicketController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = BookingTicket::paginate($perPage)->appends($request->query());
        return view('admin.booking-ticket.view', compact('data'));
    }

    public function showCreate()
    {
        $data = Exhibition::where('status', 'active')
            ->where('start_date', '>=', now())
            ->orWhere('end_date', '>=', now())
            ->get();

        return view('admin.booking-ticket.create', [
            'exhibition_list' => $data
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'exhibition_id' => 'required',
            'details' => 'required|string|max:255',
            'ticket_count' => 'required|integer|min:1'
        ]);

        // Found exhibition
        $exhibition = Exhibition::findOrFail($request->exhibition_id);

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
            'exhibition_id' => $request->exhibition_id,
            'user_id' => $user->id,
            'ticket_count' => $request->ticket_count,
            'total_price' => $exhibition->price * $request->ticket_count,
            'details' => $request->details,
            'is_paid' =>  $exhibition->price <= 0 ? true : false
        ]);

        return redirect()->route('admin.ticket')->with('success', 'Đặt vé thành công!');
    }

    public function showEdit($id)
    {
        $data = BookingTicket::findOrFail($id);
        return view('admin.booking-ticket.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'details' => 'string|max:255',
                'ticket_count' => 'integer|min:1',
                'status' => 'string|in:true,false'
            ]);

            $data = BookingTicket::findOrFail($id);

            if ($data->is_paid) {
                $data->update([
                    'details' => $request->details ?? $data->details,
                ]);

                return redirect()->route('admin.ticket')->with('success', 'Cập nhật thông tin đặt vé thành công!');
            }

            // Check if exhibition is active
            if ($data->exhibition->getIsInactiveAttribute()) {
                return redirect()->back()->withInput()->with('error', 'Buổi triển lãm không còn khả dụng!');
            }

            // Check if exhibition end date is greater than current date
            if ($data->exhibition->getIsExpiredAttribute()) {
                return redirect()->back()->withInput()->with('error', 'Buổi triển lãm đa hết thời hạn đặt vé!');
            }

            if ($data->exhibition->is_limited_tickets) {
                $available_tickets = $data->exhibition->getAvailableTicketsAttribute();

                if ($request->ticket_count > $available_tickets) {
                    return redirect()->back()->withInput()->with('error', 'Số lượng vé không đủ! ' . 'Chỉ còn lại ' . $available_tickets . ' vé!');
                }
            }

            $data->update([
                'details' => $request->details,
                'ticket_count' => $request->ticket_count,
                'total_price' => $data->exhibition->price * $request->ticket_count,
                'is_paid' => $request->status == 'true' ? true : false
            ]);

            return redirect()->route('admin.ticket')->with('success', 'Cập nhật thông tin đặt vé thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showDelete($id)
    {
        $data = BookingTicket::findOrFail($id);
        return view('admin.booking-ticket.delete', compact('data'));
    }

    public function delete($id)
    {
        $data = BookingTicket::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.ticket')->with('success', 'Xóa đặt vé thành công!');
    }
}
