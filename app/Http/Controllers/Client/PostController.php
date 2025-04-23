<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 50);
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

        // Lưu lịch sử nếu đã đăng nhập
    if (auth()->check()) {
        PostView::create([
            'user_id' => auth()->id(),
            'post_id' => $id,
            'viewed_at' => now(),
        ]);
    }
        return view('client.post.details', compact('data'));
    }

    public function increaseView($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('view_count');
        return response()->json(['views' => $post->view_count]);
    }
    public function history()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử bài viết.');
        }
    
        $user = auth()->user();
    
        $views = $user->postViews()
            ->with('post')
            ->orderByDesc('viewed_at')
            ->paginate(10);
    
        return view('client.post.history', compact('views'));
    }
}
