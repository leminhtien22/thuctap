<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Order;
use App\Models\OrderDetail;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Order::paginate($perPage)->appends($request->query());
        return view('admin.order.view', compact('data'));
    }

    public function showCreate()
    {
        $collections = Collection::where('price', '>', 0)->where('is_public', true)->where('quantity', '>', 0)->get();

        return view('admin.order.create', [
            'products' => $collections
        ]);
    }

    public function create(Request $request)
    {

        $request->validate([
            'notes' => 'required|string',
            'is_paid' => 'required|in:true,false',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:1',
        ]);

        $quantities = $request->input('quantities');
        $notes = $request->input('notes');
        $is_paid = $request->input('is_paid');
        $user = Auth::user();
        $total_price = 0;
        $total_quantity = 0;


        try {
            DB::beginTransaction();
            $orderDetails = [];

            foreach ($quantities as $collection_id => $quantity) {
                $collection = Collection::find($collection_id);

                // Check quantity
                if ($collection->quantity < $quantity) {
                    throw new Error('Sản phẩm ' . $collection->name . ' đã vượt quá số lượng ' . $collection->quantity);
                }


                $price = $collection->price;
                $total_price += $price * $quantity;
                $total_quantity += $quantity;
                $collection->quantity -= $quantity;

                $orderDetails[] = [
                    'collection_id' => $collection_id,
                    'quantity' => $quantity,
                    'price' => $price
                ];


                $collection->save();
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total_price,
                'total_quantity' => $total_quantity,
                'notes' => $notes,
                'is_paid' => $is_paid == 'true' ? true : false
            ]);

            foreach ($orderDetails as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    ...$item
                ]);
            }

            DB::commit();

            return redirect()->route('admin.order')->with('success', 'Tạo đơn hàng thành công!');
        } catch (\Throwable $th) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showEdit(string $id)
    {
        $data = Order::findOrFail($id);
        return view('admin.order.edit', compact('data'));
    }

    public function edit(Request $request, string $id)
    {
        $request->validate([
            'notes' => 'required|string',
            'is_paid' => 'nullable|in:true,false'
        ]);

        try {
            $notes = $request->input('notes');
            $is_paid = $request->input('is_paid');

            $order = Order::findOrFail($id);
            $order->notes = $notes;

            if (isset($is_paid)) {
                $order->is_paid = $is_paid == 'true' ? true : false;
            }

            $order->save();

            return redirect()->route('admin.order')->with('success', 'Đơn hàng đã được cập nhật thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showDelete(string $id)
    {
        $data = Order::findOrFail($id);
        return view('admin.order.delete', compact('data'));
    }

    public function delete(string $id)
    {

        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);

            foreach ($order->orderDetails as $item) {
                $collection = Collection::find($item->collection_id);
                $collection->quantity += $item->quantity;
                $collection->save();
            }

            $order->orderDetails()->delete();
            $order->delete();

            DB::commit();
            return redirect()->route('admin.order')->with('success', 'Đơn hàng đã được xóa thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
