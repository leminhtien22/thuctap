<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Order;
use App\Models\OrderDetail;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function history(Request $request)
    {
        $user = Auth::user();
        $limit = $request->input('limit', 10);
        $data = Order::where('user_id', $user->id)->paginate($limit)->appends($request->query());

        return view('client.order.view', compact('data'));
    }

    public function showBooking()
    {
        $data = session()->get('cart') ?? [];
        return view('client.order.create', compact('data'));
    }

    public function create(Request $request)
    {

        $request->validate([
            'notes' => 'required|string'
        ]);

        $notes = $request->input('notes');
        $carts = session()->get('cart') ?? [];
        $user = Auth::user();
        $total_price = 0;
        $total_quantity = 0;

        if(count($carts) == 0) {
            return redirect()->back()->withInput()->with('error', 'Vui lòng thêm sản phẩm vào giỏ hàng!');
        }


        try {
            DB::beginTransaction();
            $orderDetails = [];

            foreach ($carts as $collection_id => $item) {
                $collection = Collection::find($collection_id);
                $quantity = $item['quantity_buy'];

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
                'is_paid' => false
            ]);

            foreach ($orderDetails as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    ...$item
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('order.history')->with('success', 'Đã mua hàng thành công!');
        } catch (\Throwable $th) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function details($id)
    {
        $data = Order::find($id);
        return view('client.order.details', compact('data'));
    }
}
