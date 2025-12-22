<?php

namespace App\Http\Controllers\FEnd;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function account()
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route("admin.dashboard");
        }

        $user = Auth::user();

        // Cập nhật status cho rentals quá hạn
        Rentals::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('due_at', '<', now())
            ->update(['status' => 'late']);

        // Đang đọc: rentals active + có file PDF (không quá hạn)
        $readingBooks = Rentals::with(['book.images', 'book.file', 'rentalPricing', 'payments'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where('due_at', '>=', now())
            ->whereHas('book.file')
            ->whereHas('payments', function($query) {
                $query->where('status', 'paid');
            })
            ->orderByDesc('rented_at')
            ->get();

        // Yêu thích
        $favorites = Favorite::with(['book.images'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        // Tất cả đơn hàng đã thuê (refresh sau khi cập nhật status)
        $allRentals = Rentals::with(['book.images', 'rentalPricing', 'payments'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        // Phân loại đơn hàng
        $activeRentals = $allRentals->where('status', 'active');
        $returnedRentals = $allRentals->where('status', 'returned');
        $lateRentals = $allRentals->where('status', 'late');
        $pendingRentals = $allRentals->where('status', 'pending');

        // Lịch sử thanh toán
        $payments = \App\Models\Payment::with(['rental.book.images'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view("frontend.account", compact(
            'user',
            'readingBooks',
            'favorites',
            'allRentals',
            'activeRentals',
            'returnedRentals',
            'lateRentals',
            'pendingRentals',
            'payments'
        ));
    }

    /**
     * Danh sách sách yêu thích của người dùng hiện tại
     */
    public function favorites()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $favorites = Favorite::with(['book.images'])
            ->where('user_id', Auth::id())
            ->get();

        return view('frontend.favorites', compact('favorites'));
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
