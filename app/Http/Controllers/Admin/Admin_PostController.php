<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Admin_PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->with('user')->get();
        return view('admin.posts.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'content'    => 'required|string',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'     => 'required|in:draft,published',
            'categories' => 'nullable|array',
        ]);

        try {
            $post = Post::create([
                'title'      => $validated['title'],
                'slug'       => Str::slug($validated['title']) . '-' . time(),
                'summary'    => $validated['summary'] ?? null,
                'content'    => $validated['content'],
                'user_id'    => Auth::id(),
                'status'     => $validated['status'],
            ]);

            // Upload ảnh
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('posts', 'public');
                $post->update(['image' => $path]);
            }

            // Gán danh mục
            if ($request->filled('categories')) {
                $post->categories()->sync($request->categories);
            }

            return redirect()->route('admin.posts.list')->with('success', 'Thêm bài viết thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
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
        $post = Post::with('categories')->findOrFail($id);
        $categories = Category::all();

        if (!$post) {
            return back()->with('error', 'Không tìm thấy bài viết');
        }

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'      => 'required|string|max:255',
            'summary'    => 'nullable|string|max:1000',
            'content'    => 'required|string',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'     => 'required|in:draft,published',
            'categories' => 'nullable|array',
        ]);

        $post->update([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title) . '-' . time(),
            'summary'    => $request->summary,
            'content'    => $request->content,
            'status'     => $request->status,
        ]);

        // Upload ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $post->update(['image' => $path]);
        }

        // Cập nhật danh mục
        $post->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.posts.list')->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // Xóa ảnh trong storage
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.list')->with('success', 'Xóa bài viết thành công!');
    }
}
