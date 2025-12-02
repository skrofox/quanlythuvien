<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookImage;
use App\Models\BookFile;
use App\Models\Category;
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
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'summary'   => 'nullable|string|max:1000',
            'publisher' => 'nullable|string|max:255',
            'year'      => 'nullable|integer',
            'images.*'  => 'image|mimes:jpg,jpeg,png|max:2048',
            'pdf_file'  => 'nullable|file|mimes:pdf|max:51200', // Max 50MB
            'categories' => 'array', // validate mảng danh mục
        ]);

        $book = Book::create([
            'name'      => $request->name,
            'author'    => $request->author,
            'summary'   => $request->summary,
            'publisher' => $request->publisher,
            'year'      => $request->year,
            'slug'      => Str::slug($request->name) . '-' . time(),
        ]);

        // Gán danh mục
        if ($request->filled('categories')) {
            $book->categories()->sync($request->categories);
        }

        // Upload ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('books', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'url'     => $path,
                ]);
            }
        }

        // Upload PDF file (lưu trong public storage)
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $originalName = $pdfFile->getClientOriginalName();
            $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.pdf';
            $filePath = $pdfFile->storeAs('book_files/pdf', $fileName, 'public');

            BookFile::create([
                'book_id' => $book->id,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_size' => $pdfFile->getSize(),
                'mime_type' => $pdfFile->getMimeType(),
            ]);
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
        $book = Book::with(['images', 'file'])->findOrFail($id);
        $categories = Category::all();


        if (!$book) {
            return back()->with('error', 'Err');
        }

        return view('admin.books.edit', compact('book', 'categories'));
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
            'summary'   => 'nullable|string|max:1000',
            'publisher' => 'nullable|string|max:255',
            'year'      => 'nullable|integer',
            'images.*'  => 'image|mimes:jpg,jpeg,png|max:2048',
            'pdf_file'  => 'nullable|file|mimes:pdf|max:51200', // Max 50MB
            'categories' => 'array',
        ]);

        $book->update([
            'name'      => $request->name,
            'author'    => $request->author,
            'summary'   => $request->summary,
            'publisher' => $request->publisher,
            'year'      => $request->year,
            'slug'      => Str::slug($request->name)  . '-' . time(),
        ]);

        // Cập nhật danh mục
        $book->categories()->sync($request->categories ?? []);

        // Nếu có ảnh mới thì xoá ảnh cũ trước
        if ($request->hasFile('images')) {
            // Xoá ảnh cũ trong storage và DB
            foreach ($book->images as $img) {
                Storage::disk('public')->delete($img->url);
                $img->delete();
            }

            // Upload ảnh mới
            foreach ($request->file('images') as $file) {
                $path = $file->store('books', 'public');
                BookImage::create([
                    'book_id' => $book->id,
                    'url'     => $path,
                ]);
            }
        }

        // Xử lý upload PDF file mới
        if ($request->hasFile('pdf_file')) {
            // Xóa file PDF cũ nếu có
            if ($book->file) {
                Storage::disk('public')->delete($book->file->file_path);
                $book->file->delete();
            }

            // Upload PDF mới
            $pdfFile = $request->file('pdf_file');
            $originalName = $pdfFile->getClientOriginalName();
            $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.pdf';
            $filePath = $pdfFile->storeAs('book_files/pdf', $fileName, 'public');

            BookFile::create([
                'book_id' => $book->id,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'file_size' => $pdfFile->getSize(),
                'mime_type' => $pdfFile->getMimeType(),
            ]);
        }

        return redirect()->route('admin.books.list')->with('success', 'Cập nhật sách thành công!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::with(['images', 'file'])->findOrFail($id);

        // Xóa ảnh trong storage
        foreach ($book->images as $img) {
            if ($img->url) {
                Storage::disk('public')->delete($img->url);
            }
            $img->delete();
        }

        // Xóa file PDF nếu có
        if ($book->file) {
            Storage::disk('public')->delete($book->file->file_path);
            $book->file->delete();
        }

        $book->delete();

        return redirect()->route('admin.books.list')->with('success', 'Xóa sách thành công!');
    }
}
