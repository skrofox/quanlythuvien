<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rentals;
use App\Models\RentalPricing;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index($slug)
    {
        $book = Book::with(['images', 'categories'])->where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $rentalPricings = RentalPricing::where('is_active', true)->orderBy('period_days')->get();
        return view('frontend.book-rental', compact('book', 'user', 'rentalPricings'));
    }

    public function store(Request $request, $slug)
    {

    }

}
