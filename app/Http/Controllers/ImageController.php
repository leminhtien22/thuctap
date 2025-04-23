<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the images.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $images = Image::latest()->paginate(10); // Phân trang, 10 ảnh mỗi trang
        return view('admin.photo.image', compact('images')); // Sửa admin.images thành admin.photo.image
    }

    /**
     * Show the form for creating a new image.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.photo.create');
    }

    /**
     * Store a newly uploaded image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn file ảnh
        ]);

        // Lưu ảnh vào thư mục storage/app/public/images
        $path = $request->file('image')->store('images', 'public');

        // Lưu đường dẫn vào cơ sở dữ liệu
        Image::create([
            'url' => $path,
        ]);

        return redirect()->route('admin.photo')->with('success', 'Ảnh đã được tải lên thành công.');
    }

    /**
     * Show the form for editing an image.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('admin.photo.edit', compact('image'));
    }

    /**
     * Update the specified image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);

        $request->validate([
            'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('new_image')) {
            // Xóa ảnh cũ
            Storage::disk('public')->delete($image->url);

            // Lưu ảnh mới
            $path = $request->file('new_image')->store('images', 'public');
            $image->url = $path;
            $image->save();
        }

        return redirect()->route('admin.photo')->with('success', 'Ảnh đã được cập nhật thành công.');
    }

    /**
     * Remove the specified image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Xóa file ảnh khỏi storage
        Storage::disk('public')->delete($image->url);

        // Xóa bản ghi trong cơ sở dữ liệu
        $image->delete();

        return redirect()->route('admin.photo')->with('success', 'Ảnh đã được xóa thành công.');
    }
}