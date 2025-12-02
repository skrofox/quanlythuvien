<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookFavoriteController extends Controller
{
    public function store($id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user();

        $favorite = Favorite::where("user_id", $user->id)->where("book_id", $book->id)->first();
        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with("success", "Đã xóa khỏi danh sách yêu thích");
        } else {
            Favorite::create([
                "user_id" => $user->id,
                "book_id" => $book->id,
            ]);
            return redirect()->back()->with("success", "Đã thêm vào danh sách yêu thích");
        }
    }
}
