<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Shop::paginate($perPage)->appends($request->query());
        return view('admin.shop.view', compact('data'));
    }

    public function showCreate()
    {
        return view('admin.shop.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'is_public' => 'required|in:true,false',
            'type' => 'required|in:painting,sculpture,statues,fossils,handicrafts,others',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:2048',
        ]);

        try {
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('images', 'public');
                    $imagePaths[] = $path;
                }
            }

            Shop::create([
                'name' => $request->name,
                'thumbnail' => $thumbnailPath,
                'description' => $request->description,
                'is_public' => $request->is_public == 'true' ? true : false,
                'type' => $request->type,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'slug' => str()->slug($request->name),
                'images' => json_encode($imagePaths),
            ]);

            return redirect()->route('admin.shop')->with('success', 'Thêm mới cửa hàng thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showEdit($id)
    {
        $data = Shop::findOrFail($id);
        return view('admin.shop.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'is_public' => 'required|in:true,false',
                'type' => 'required|in:painting,sculpture,statues,fossils,handicrafts,others',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'images' => 'array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:2048',
                'images-exist' => 'string|nullable',
            ]);

            $images_exist = $request->input('images-exist') != null || $request->input('images-exist') != '' ? json_decode($request->input('images-exist'), true) : [];

            if (empty($images_exist) && empty($request->file('images'))) {
                return redirect()->back()->withInput()->withErrors(['images' => 'Vui lòng tải lên ít nhất một ảnh!']);
            }

            $shop = Shop::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                if ($shop->thumbnail) {
                    Storage::disk('public')->delete($shop->thumbnail);
                }
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $shop->thumbnail = $thumbnailPath;
            }

            $oldImage = $shop->images_json;

            $deleteImage = [];

            foreach ($oldImage as $image) {
                if (isset($image) && $image !== null && !in_array($image, $images_exist)) {
                    $deleteImage[] = $image;
                    $oldImage = array_diff($oldImage, $deleteImage);
                }
            }

            if (!empty($deleteImage)) {
                foreach ($deleteImage as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('images', 'public');
                    array_push($oldImage, $path);
                }
            }

            $shop->name = $request->name;
            $shop->description = $request->description;
            $shop->is_public = $request->is_public == 'true' ? true : false;
            $shop->type = $request->type;
            $shop->price = $request->price;
            $shop->quantity = $request->quantity;
            $shop->slug = str()->slug($request->name);
            $shop->images = json_encode($oldImage);

            $shop->save();

            return redirect()->route('admin.shop')->with('success', 'Cập nhật cửa hàng thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showDelete($id)
    {
        $data = Shop::findOrFail($id);
        return view('admin.shop.delete', compact('data'));
    }

    public function delete($id)
    {
        $shop = Shop::findOrFail($id);
        if ($shop->thumbnail) {
            Storage::disk('public')->delete($shop->thumbnail);
        }

        foreach (json_decode($shop->images) as $image) {
            Storage::disk('public')->delete($image);
        }

        $shop->delete();

        return redirect()->route('admin.shop')->with('success', 'Xóa cửa hàng thành công.');
    }
}
