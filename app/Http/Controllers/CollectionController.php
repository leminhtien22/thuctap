<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $data = Collection::paginate($perPage)->appends($request->query());
        return view('admin.collection.view', compact('data'));
    }

    public function showCreate()
    {
        return view('admin.collection.create');
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
            'images' => 'required|array',  // Bắt buộc phải là mảng
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:2048', // Kiểm tra từng ảnh
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


            Collection::create([
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

            return redirect()->route('admin.collection')->with('success', 'Thêm mới bộ sưu tập thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showEdit($id)
    {
        $data = Collection::findOrFail($id);
        return view('admin.collection.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'is_public' => 'required|in:true,false',
                'type' => 'required|in:painting,sculpture,statues,fossils,handicrafts,others',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'images' => 'array',  // Bắt buộc nếu không có ảnh cũ
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:2048', // Kiểm tra từng ảnh
                'images-exist' => 'string|nullable',
            ]);

            $images_exist = $request->input('images-exist') != null || $request->input('images-exist') != '' ? json_decode($request->input('images-exist'), true) : [];



            // Nếu images-exist chỉ chứa giá trị null hoặc rỗng, bắt buộc phải có images
            if (empty($images_exist) && empty($request->file('images'))) {
                return redirect()->back()->withInput()->withErrors(['images' => 'Vui lòng tải lên ít nhất một ảnh!']);
            }


            $collection = Collection::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                if ($collection->thumbnail) {
                    Storage::disk('public')->delete($collection->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $collection->thumbnail = $thumbnailPath;
            }


            $oldImage = $collection->images_json;

            $deleteImage = [];

            foreach ($oldImage as $image) {
                // If image old is not in images_exist array
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

            $collection->name = $request->name;
            $collection->description = $request->description;
            $collection->is_public = $request->is_public == 'true' ? true : false;
            $collection->type = $request->type;
            $collection->price = $request->price;
            $collection->quantity = $request->quantity;
            $collection->slug = str()->slug($request->name);
            $collection->images = json_encode($oldImage);

            $collection->save();

            return redirect()->route('admin.collection')->with('success', 'Cập nhật bộ sưu tập công thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function showDelete($id)
    {
        $data = Collection::findOrFail($id);
        return view('admin.collection.delete', compact('data'));
    }

    public function delete($id)
    {
        $collection = Collection::findOrFail($id);
        if ($collection->thumbnail) {
            Storage::disk('public')->delete($collection->thumbnail);
        }

        foreach (json_decode($collection->images) as $image) {
            Storage::disk('public')->delete($image);
        }

        $collection->delete();

        return redirect()->route('admin.collection')->with('success', 'Xóa bộ sưu tập công thành công.');
    }
}