<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $data = session()->get('cart') ?? [];

        // dd($data);

        return view('client.cart', compact('data'));
    }


    public function addToCart($id)
    {
        $data = Collection::findOrFail($id);

        if ($data->quantity <= 0) {
            return redirect()->route('cart')->with('error', 'Sản phẩm không có trong kho!');
        }

        if (session()->has('cart.' . $id)) {
            session()->put('cart.' . $id, [
                ...session()->get('cart.' . $id),
                'quantity_buy' => session()->get('cart.' . $id)['quantity_buy'] + 1,
            ]);
        } else {
            // Add product to cart
            session()->put('cart.' . $id, [
                ...$data->toArray(),
                'quantity_buy' => 1,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Bộ sưu tập đã được thêm vào giỏ hàng!');
    }

    public function removeFromCart($id)
    {
        session()->forget('cart.' . $id);
        return redirect()->route('cart')->with('success', 'Đã xoá Bộ sưu tập khỏi giỏ hàng!');
    }
}
