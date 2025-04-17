<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $data = Collection::paginate($limit)->appends($request->query())->where('is_public', true);

        return view('client.collection.view', compact('data'));
    }

    public function details($id)
    {
        $data = Collection::findOrFail($id);

        if ($data->getIsInactiveAttribute()) {
            abort(404);
        }
        
        return view('client.collection.details', compact('data'));
    }
}
