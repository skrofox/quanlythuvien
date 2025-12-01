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
        $request->validate([
            'rental_pricing_id' => 'required|exists:rental_pricings,id',
            'payment_method' => 'required|string|in:momo,paypal,credit_card,bank_transfer',
        ]);

        $book = Book::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $rentalPricing = RentalPricing::findOrFail($request->rental_pricing_id);

        // Kiểm tra xem sách có đang được mượn không
        if ($book->status === 'mượn' || $book->status === 'đọc') {
            return back()->with('error', 'Sách này đang được mượn, vui lòng chọn sách khác!');
        }

        DB::beginTransaction();
        try {
            // Tạo rental với status pending
            $rentedAt = Carbon::now();
            $dueAt = $rentedAt->copy()->addDays($rentalPricing->period_days);

            $rental = Rentals::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'rental_pricing_id' => $rentalPricing->id,
                'rented_at' => $rentedAt,
                'due_at' => $dueAt,
                'status' => 'pending',
            ]);

            // Tạo payment với status pending
            $payment = Payment::create([
                'user_id' => $user->id,
                'rental_id' => $rental->id,
                'amount' => $rentalPricing->price,
                'method' => $request->payment_method,
                'status' => 'pending',
            ]);

            DB::commit();

            // Trong thực tế, ở đây bạn sẽ redirect đến gateway thanh toán
            // Sau khi thanh toán thành công, gateway sẽ gọi callback
            // Để demo, tôi sẽ tạo một route callback để xử lý
            return redirect()->route('book.rental.payment.process', $payment->id)
                ->with('success', 'Đang chuyển đến trang thanh toán...');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function paymentProcess($paymentId)
    {
        $payment = Payment::with(['rental.book', 'rental.rentalPricing'])->findOrFail($paymentId);

        // Kiểm tra quyền truy cập
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        // Trong thực tế, đây sẽ là trang thanh toán của gateway
        // Để demo, tôi sẽ tạo một trang xác nhận thanh toán
        return view('frontend.payment-process', compact('payment'));
    }

    public function paymentCallback(Request $request, $paymentId)
    {
        $payment = Payment::with(['rental.book'])->findOrFail($paymentId);

        // Kiểm tra quyền truy cập
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        // Trong thực tế, đây sẽ là callback từ payment gateway
        // Để demo, tôi sẽ xử lý thanh toán thành công
        DB::beginTransaction();
        try {
            // Cập nhật payment status
            $payment->update([
                'status' => 'paid',
            ]);

            // Cập nhật rental status
            $payment->rental->update([
                'status' => 'active',
            ]);

            // Cập nhật book status từ "available" => "đọc"
            $payment->rental->book->update([
                'status' => 'đọc',
            ]);

            DB::commit();

            return redirect()->route('book.rental.success', $payment->id)
                ->with('success', 'Thanh toán thành công! Bạn có thể đọc sách ngay bây giờ.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
        }
    }

    public function paymentSuccess($paymentId)
    {
        $payment = Payment::with(['rental.book', 'rental.rentalPricing'])->findOrFail($paymentId);

        // Kiểm tra quyền truy cập
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.payment-success', compact('payment'));
    }
}
