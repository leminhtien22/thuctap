<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $data = Shop::where('is_public', true)
                    ->paginate($limit)
                    ->appends($request->query());

        return view('client.shop.view', compact('data'));
    }

    public function details($id)
    {
        $data = Shop::findOrFail($id);

        if ($data->getIsInactiveAttribute()) {
            abort(404);
        }
        
        return view('client.shop.details', compact('data'));
    }
}
