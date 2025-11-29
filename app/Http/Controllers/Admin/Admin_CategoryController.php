<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Admin_CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.list', compact('categories'));
    }


    public function store(Request $request)
    {
        $slug = $request->name;
        $slug = Str::slug($slug);
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required|string',
        ]);

        if(Category::where('slug', $slug)->first() == null){
            Category::create([
                'name'     => $validated['name'],
                'description'     => $validated['description'],
                'slug' => $slug,
            ]);
            return back()->with('success', 'Thêm thành công');
        }


        return back()->with('Err', 'Thêm khong thành công');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            return back();
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $slug = $request->name;
        $slug = Str::slug($slug);
        $request->validate([
            'name'  => 'required|string|max:255',
            'description'  => 'required|string',
            'slug' => $slug
        ]);

        $category = Category::findOrFail($id);
        if(!$category){
            return back()->with('error', 'Error');
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.categories.list')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {

        $category = Category::findOrFail($id)->delete();

        if (!$category) {
            return back()->with('error', "Oh no, It's err");
        }

        return back()->with('success', 'Delete Category Successfully');
    }
}
