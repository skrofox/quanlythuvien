<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Admin_BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->with('images')->get();
        return view('admin.books.list', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year'      => 'nullable|integer',
            'slug'      => 'nullable|string|max:255',
            'images.*'  => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $book = Book::create([
            'name'      => $request->name,
            'author'    => $request->author,
            'publisher' => $request->publisher,
            'year'      => $request->year,
            'slug'      => $request->slug ?? Str::slug($request->name),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('books', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'url'    => $path,
                ]);
            }
        }

        return redirect()->route('admin.books.list')->with('success', 'Thêm sách thành công!');
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
        $book = Book::with('images')->findOrFail($id);

        if(!$book){
            return back()->with('error', 'Err');
        }

        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year'      => 'nullable|integer',
            'images.*'  => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $book->update([
            'name'      => $request->name,
            'author'    => $request->author,
            'publisher' => $request->publisher,
            'year'      => $request->year,
            'slug'      => $request->slug ?? Str::slug($request->name) . '-' . time(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('books', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'url'    => $path,
                ]);
            }
        }

        return redirect()->route('admin.books.list')->with('success', 'Cập nhật sách thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        // Xóa ảnh trong storage
        foreach ($book->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }
        $book->delete();

        return redirect()->route('admin.books.list')->with('success', 'Xóa sách thành công!');
    }

}
