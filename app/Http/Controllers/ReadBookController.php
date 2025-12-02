<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ReadBookController extends Controller
{

    public function read($slug)
    {
        $book = Book::with('images', 'categories', 'file')->where('slug', $slug)->firstOrFail();

        // Kiểm tra user đã đăng nhập chưa (middleware auth đã xử lý, nhưng kiểm tra lại để chắc chắn)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đọc sách.');
        }

        // Kiểm tra sách có file PDF chưa
        if (!$book->file) {
            return redirect()->route('book.detail', $book->slug)
                ->with('error', 'Sách này chưa có file PDF.');
        }

        // Kiểm tra quyền truy cập: user đã mượn sách và còn active
        $rental = Rentals::where('book_id', $book->id)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$rental) {
            return redirect()->route('book.detail', $book->slug)
                ->with('error', 'Bạn chưa mượn sách này hoặc đã hết hạn. Vui lòng mượn sách để đọc.');
        }

        // Lấy URL PDF từ public storage
        $pdfUrl = Storage::url($book->file->file_path);

        // dd($pdfUrl);

        return view('frontend.read-book', compact('book', 'rental', 'pdfUrl'));
    }
}
