<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $users = User::paginate($perPage)->appends($request->query());
        return view('admin.user.view', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'avatar' => $avatarPath,
        ]);

        return redirect()->route('admin.user')->with('success', 'Người dùng đã được tạo thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function editUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.user')->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    public function ban(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.ban', compact('user'));
    }

    public function banUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->status = 'inactive';

        $user->save();

        return redirect()->route('admin.user')->with('success', "Người dùng $user->name đã bị khóa!");
    }

    public function unBan(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.un-ban', compact('user'));
    }

    public function unBanUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->status = 'active';

        $user->save();

        return redirect()->route('admin.user')->with('success', "Người dùng $user->name đã được mở khoá!");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
