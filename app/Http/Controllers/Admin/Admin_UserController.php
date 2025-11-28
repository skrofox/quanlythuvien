<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Admin_UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.list', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
        ]);

        return back()->with('success', 'Thêm thành công');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return back();
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id",
            'password' => 'nullable|min:6',
            'role' => 'required|string'
        ]);

        $user = User::findOrFail($id);

        $data = $request->only(['name', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.list')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {

        $user = User::findOrFail($id)->delete();

        if (!$user) {
            return back()->with('error', "Oh no, It's err");
        }

        return back()->with('success', 'Delete User Successfully');
    }
}
