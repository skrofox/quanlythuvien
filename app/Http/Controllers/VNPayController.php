<?php

namespace App\Http\Controllers;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

use App\Models\RentalPricing;
use App\Models\Book;
use App\Models\Rentals;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VNPayController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        $rental_pricing = RentalPricing::find($request->input("rental_pricing_id"));
        $book_slug = $request->input("book_slug");

        if (!$rental_pricing || !$book_slug) {
            return back()->with('error', 'Thông tin không hợp lệ.');
        }

        $book = Book::where('slug', $book_slug)->first();
        if (!$book) {
            return back()->with('error', 'Sách không tồn tại.');
        }

        $vnp_Url = env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnp_Returnurl = env('VNP_RETURN_URL');
        $vnp_TmnCode = env('VNP_TMNCODE'); //Mã website tại VNPAY
        $vnp_HashSecret = env('VNP_HASHSECRET'); //Chuỗi bí mật

        // Kiểm tra các thông tin bắt buộc
        if (empty($vnp_TmnCode) || empty($vnp_HashSecret) || empty($vnp_Returnurl)) {
            return back()->with('error', 'Cấu hình thanh toán chưa đầy đủ. Vui lòng kiểm tra lại.');
        }

        // Tạo mã đơn hàng duy nhất (timestamp + random)
        $vnp_TxnRef = time() . rand(1000, 9999);
        $vnp_OrderInfo = 'Thanh toán thuê sách';
        $vnp_OrderType = 'billpayment';
        // VNPay yêu cầu số tiền phải nhân 100 (ví dụ: 10,000 VND = 1000000)
        $vnp_Amount = $rental_pricing->price * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,

        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo SecureHash
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // Build URL - loại bỏ dấu & cuối cùng của query và thêm SecureHash
        $query = rtrim($query, '&'); // Loại bỏ dấu & cuối cùng
        $vnp_Url = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;

        // Lưu thông tin đơn hàng vào session để xử lý sau khi thanh toán
        session([
            'vnpay_order' => [
                'txn_ref' => $vnp_TxnRef,
                'book_id' => $book->id,
                'rental_pricing_id' => $rental_pricing->id,
                'amount' => $rental_pricing->price,
                'user_id' => Auth::id(),
            ]
        ]);

        // Kiểm tra nếu là AJAX request thì trả về JSON, ngược lại redirect
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            ]);
        }

        // Mặc định redirect đến trang thanh toán VNPay
        return redirect($vnp_Url);
    }

    public function vnpay_return(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASHSECRET');

        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_Amount = $request->input('vnp_Amount');
        $vnp_TransactionNo = $request->input('vnp_TransactionNo');
        $vnp_BankCode = $request->input('vnp_BankCode');
        $vnp_PayDate = $request->input('vnp_PayDate');
        $vnp_OrderInfo = $request->input('vnp_OrderInfo');

        // Kiểm tra xem đơn hàng đã được xử lý chưa (tránh xử lý trùng)
        $existingPayment = Payment::where('order_code', $vnp_TxnRef)->first();
        if ($existingPayment && $existingPayment->status == 'paid') {
            // Đơn hàng đã được xử lý rồi, load lại thông tin
            $rental = $existingPayment->rental;
            $rental->load(['book', 'rentalPricing']);

            return view('frontend.payment-result', [
                'success' => true,
                'message' => 'Đơn hàng đã được xử lý trước đó.',
                'order_id' => $vnp_TxnRef,
                'transaction_no' => $existingPayment->vnpay_transaction_no,
                'amount' => $existingPayment->amount,
                'rental' => $rental,
            ]);
        }

        // Lấy thông tin đơn hàng từ session
        $orderInfo = session('vnpay_order');

        if (!$orderInfo || $orderInfo['txn_ref'] != $vnp_TxnRef) {
            return view('frontend.payment-result', [
                'success' => false,
                'message' => 'Thông tin đơn hàng không hợp lệ hoặc session đã hết hạn.',
                'order_id' => $vnp_TxnRef
            ]);
        }

        // Xác thực checksum
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);
        ksort($inputData);

        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash != $vnp_SecureHash) {
            return view('frontend.payment-result', [
                'success' => false,
                'message' => 'Chữ ký không hợp lệ.',
                'order_id' => $vnp_TxnRef
            ]);
        }

        // Kiểm tra kết quả thanh toán
        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công
            try {
                DB::beginTransaction();

                // Tạo rental record
                $rentalPricing = RentalPricing::find($orderInfo['rental_pricing_id']);
                $rentedAt = Carbon::now();
                $dueAt = $rentedAt->copy()->addDays($rentalPricing->period_days);

                $rental = Rentals::create([
                    'user_id' => $orderInfo['user_id'],
                    'book_id' => $orderInfo['book_id'],
                    'rental_pricing_id' => $orderInfo['rental_pricing_id'],
                    'rented_at' => $rentedAt,
                    'due_at' => $dueAt,
                    'status' => 'active',
                ]);

                // Load relationships cho view
                $rental->load(['book', 'rentalPricing']);

                // Tạo payment record
                $payment = Payment::create([
                    'order_code' => $vnp_TxnRef, // Mã đơn hàng
                    'user_id' => $orderInfo['user_id'],
                    'rental_id' => $rental->id,
                    'amount' => $orderInfo['amount'],
                    'method' => 'vnpay',
                    'status' => 'paid',
                    'vnpay_transaction_no' => $vnp_TransactionNo, // Mã giao dịch VNPay
                    'vnpay_bank_code' => $vnp_BankCode, // Mã ngân hàng
                    'vnpay_pay_date' => $vnp_PayDate ? Carbon::createFromFormat('YmdHis', $vnp_PayDate) : null, // Ngày thanh toán
                ]);

                // Lưu thông tin giao dịch VNPay vào payment (có thể thêm field vnp_transaction_no vào Payment model nếu cần)

                DB::commit();

                // Xóa session
                session()->forget('vnpay_order');

                return view('frontend.payment-result', [
                    'success' => true,
                    'message' => 'Thanh toán thành công!',
                    'order_id' => $vnp_TxnRef,
                    'transaction_no' => $vnp_TransactionNo,
                    'amount' => $orderInfo['amount'],
                    'rental' => $rental,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return view('frontend.payment-result', [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi lưu đơn hàng: ' . $e->getMessage(),
                    'order_id' => $vnp_TxnRef
                ]);
            }
        } else {
            // Thanh toán thất bại
            $errorMessages = [
                '07' => 'Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
                '09' => 'Thẻ/Tài khoản chưa đăng ký dịch vụ InternetBanking.',
                '10' => 'Xác thực thông tin thẻ/tài khoản không đúng quá 3 lần.',
                '11' => 'Đã hết hạn chờ thanh toán.',
                '12' => 'Thẻ/Tài khoản bị khóa.',
                '13' => 'Nhập sai mật khẩu xác thực giao dịch (OTP).',
                '24' => 'Khách hàng hủy giao dịch.',
                '51' => 'Tài khoản không đủ số dư để thực hiện giao dịch.',
                '65' => 'Tài khoản đã vượt quá hạn mức giao dịch trong ngày.',
                '75' => 'Ngân hàng thanh toán đang bảo trì.',
                '79' => 'Nhập sai mật khẩu thanh toán quá số lần quy định.',
            ];

            $errorMessage = $errorMessages[$vnp_ResponseCode] ?? 'Giao dịch không thành công.';

            return view('frontend.payment-result', [
                'success' => false,
                'message' => $errorMessage,
                'order_id' => $vnp_TxnRef,
                'response_code' => $vnp_ResponseCode,
            ]);
        }
    }
}
