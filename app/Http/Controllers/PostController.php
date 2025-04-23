<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $images = Image::all(); // Fetch all images for the modal
        return view('admin.post.create', compact('images'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content_text' => 'required|string',
                'content_html' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'thumbnail_id' => 'nullable|exists:images,id',
                'status' => 'required|in:active,inactive',
            ]);

            $user = Auth::user();
            $thumbnailPath = '';

            if ($request->hasFile('thumbnail')) {
                // Store new thumbnail
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            } elseif ($request->filled('thumbnail_id')) {
                // Use existing image
                $image = Image::find($request->thumbnail_id);
                $thumbnailPath = $image->url;
            } else {
                return redirect()->back()->withInput()->with('error', 'Vui lòng chọn hoặc tải lên ảnh đại diện.');
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
        $images = Image::all(); // Fetch images for edit form if needed
        return view('admin.post.edit', compact('data', 'images'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content_text' => 'required|string',
                'content_html' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'thumbnail_id' => 'nullable|exists:images,id',
                'status' => 'required|in:active,inactive',
            ]);

            $post = Post::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if it exists
                if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                    Storage::disk('public')->delete($post->thumbnail);
                }
                $post->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
            } elseif ($request->filled('thumbnail_id')) {
                // Use existing image
                $image = Image::find($request->thumbnail_id);
                $post->thumbnail = $image->url;
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