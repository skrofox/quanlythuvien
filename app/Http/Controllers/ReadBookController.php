<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReadBookController extends Controller
{
    public function read($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        return view('frontend.read-book', compact('book'));
    }
}
