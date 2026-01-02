<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra user đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        }

        $user = Auth::user();

        // Kiểm tra user đã/đang thuê sách này chưa
        $hasRented = Rentals::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->whereIn('status', ['active', 'returned', 'late'])
            ->exists();

        if (!$hasRented) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá sách mà bạn đã hoặc đang thuê.');
        }

        // Kiểm tra user đã đánh giá sách này chưa
        $existingReview = Review::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá cuốn sách này rồi.');
        }

        // Tạo review
        Review::create([
            'user_id' => $user->id,
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá cuốn sách này!');
    }

    /**
     * Remove the specified review.
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập.');
        }

        $review = Review::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền: admin hoặc chính user đó
        if ($user->role !== 'admin' && $review->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa đánh giá này.');
        }

        $bookId = $review->book_id;
        $review->delete();

        return redirect()->back()->with('success', 'Đã xóa đánh giá thành công.');
    }
}

