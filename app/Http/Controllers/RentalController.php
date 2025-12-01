<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index($slug)
    {
        $book = Book::with(['images', 'categories'])->where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        return view('frontend.book-rental', compact('book', 'user'));
    }
}
