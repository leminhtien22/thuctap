<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Post::paginate($perPage)->appends($request->query());
        return view('admin.post.view', compact('data'));
    }

    public function showTrash(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Post::onlyTrashed()->paginate($perPage)->appends($request->query());
        return view('admin.post.trash', compact('data'));
    }

    public function showCreate()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'content_text' => 'required|string',
                'content_html' => 'required|string',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            $user = Auth::user();

            $thumbnailPath = '';

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            Post::create([
                'title' => $request->title,
                'content_text' => $request->content_text,
                'content_html' => $request->content_html,
                'thumbnail' => $thumbnailPath,
                'status' => $request->status,
                'user_id' => $user->id,
                'slug' => str()->slug($request->title),
                'view_count' => 0
            ]);

            return redirect()->route('admin.post')->with('success', 'Đã tạo bài viết mới thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showEdit($id)
    {
        $data = Post::findOrFail($id);
        return view('admin.post.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content_text' => 'required|string',
                'content_html' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            $post = Post::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                if ($post->thumbnail) {
                    unlink(public_path('storage/' . $post->thumbnail));
                }
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $post->thumbnail = $thumbnailPath;
            }

            $post->title = $request->title;
            $post->content_text = $request->content_text;
            $post->content_html = $request->content_html;
            $post->status = $request->status;
            $post->slug = str()->slug($request->title);
            $post->save();

            return redirect()->route('admin.post')->with('success', 'Đã cập nhật bài viết.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showDelete($id)
    {
        $data = Post::findOrFail($id);
        return view('admin.post.delete', compact('data'));
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.post')->with('success', 'Đã xoá bài viết ' . $post->title . ' thành công.');
    }

    public function showRestore($id)
    {
        $data = Post::withTrashed()->findOrFail($id);
        return view('admin.post.restore', compact('data'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('admin.post')->with('success', 'Bài viết ' . $post->title . ' đã được khôi phục.');
    }
}
