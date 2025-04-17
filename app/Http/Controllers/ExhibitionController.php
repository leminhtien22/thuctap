<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Exhibition::paginate($perPage)->appends($request->query());
        return view('admin.exhibition.view', compact('data'));
    }

    public function showTrash(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Exhibition::onlyTrashed()->paginate($perPage)->appends($request->query());
        return view('admin.exhibition.trash', compact('data'));
    }

    public function showCreate()
    {
        return view('admin.exhibition.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'total_tickets' => 'integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Convert start_date and end_date to Carbon instances
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $now = now();

        // Check if start_date is in the past
        if ($startDate->lessThan($now)) {
            return redirect()->back()->withInput()->withErrors(['start_date' => 'Thời gian bắt đầu buổi triển lãm phải lớn hơn thời gian hiện tại!']);
        }

        // Check if end_date is before start_date
        if ($endDate->lessThan($startDate)) {
            return redirect()->back()->withInput()->withErrors(['end_date' => 'Thời gian kết thúc buổi triển lãm phải lớn hơn thời gian bắt đầu!']);
        }

        // Check if end_date - start_date >= 30 minutes
        if ($startDate->diffInMinutes($endDate) < 30) {
            return redirect()->back()->withInput()->withErrors(['end_date' => 'Thời gian kết thúc buổi triển lãm phải lớn hơn 30 phút!']);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Exhibition::create([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $request->status,
            'total_tickets' => $request->total_tickets,
            'is_limited_tickets' => $request->total_tickets > 0,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.exhibition')->with('success', 'Buổi triển lãm đã được thêm thành công!');
    }

    public function showEdit($id)
    {
        $data = Exhibition::findOrFail($id);
        return view('admin.exhibition.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'total_tickets' => 'integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = Exhibition::findOrFail($id);

        // Convert start_date and end_date to Carbon instances
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $now = now();

        // Check if start_date is in the past
        if ($startDate->lessThan($now)) {
            return redirect()->back()->withInput()->withErrors(['start_date' => 'Thời gian bắt đầu buổi triển lãm phải lớn hơn thời gian hiện tại!']);
        }

        // Check if end_date is before start_date
        if ($endDate->lessThan($startDate)) {
            return redirect()->back()->withInput()->withErrors(['end_date' => 'Thời gian kết thúc buổi triển lãm phải lớn hơn thời gian bắt đầu!']);
        }

        // Check if end_date - start_date >= 30 minutes
        if ($startDate->diffInMinutes($endDate) < 30) {
            return redirect()->back()->withInput()->withErrors(['end_date' => 'Thời gian kết thúc buổi triển lãm phải lớn hơn 30 phút!']);
        }

        $imagePath = $data->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $data->update([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $request->status,
            'total_tickets' => $request->total_tickets,
            'is_limited_tickets' => $request->total_tickets > 0,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.exhibition')->with('success', 'Buổi triển lãm đã được cập nhật!');
    }

    public function showDelete($id)
    {
        $data = Exhibition::findOrFail($id);
        return view('admin.exhibition.delete', compact('data'));
    }

    public function delete($id)
    {
        $data = Exhibition::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.exhibition')->with('success', 'Buổi triển lãm được xóa!');
    }

    public function restore($id)
    {
        $data = Exhibition::withTrashed()->findOrFail($id);
        $data->restore();
        return redirect()->route('admin.exhibition.trash')->with('success', 'Buổi triển lãm được khôi phục!');
    }

    public function getExhibition(Request $request)
    {
        $data = Exhibition::findOrFail($request->id);
        return response()->json($data);
    }
}
