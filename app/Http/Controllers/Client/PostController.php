<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $searchingName = $request->input('q') ?? '';
        $data = Post::paginate($limit)->appends($request->query());

        if ($searchingName) {
            $data = Post::where('title', 'like', '%' . $searchingName . '%')->paginate($limit)->appends($request->query());
        }

        return view('client.post.view', compact('data'));
    }

    public function details($id)
    {
        $data = Post::findOrFail($id);

        if ($data->getIsInactiveAttribute()) {
            abort(404);
        }

        return view('client.post.details', compact('data'));
    }

    public function increaseView($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('view_count');
        return response()->json(['views' => $post->view_count]);
    }
}
