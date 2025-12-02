<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";

    protected $fillable = [
        "order_code", // Mã đơn hàng (vnp_TxnRef)
        "user_id",
        "rental_id",
        "amount", // số tiền thanh toán
        "method", // phương thức: momo, paypal, credit_card, vnpay...
        "status", // trạng thái: pending, paid, failed, refunded
        "vnpay_transaction_no", // Mã giao dịch từ VNPay
        "vnpay_bank_code", // Mã ngân hàng
        "vnpay_pay_date", // Ngày thanh toán từ VNPay
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function rental(){
        return $this->belongsTo(Rentals::class, "rental_id", "id");
    }

    /**
     * Scope để tìm kiếm theo mã đơn hàng
     */
    public function scopeByOrderCode($query, $orderCode)
    {
        return $query->where('order_code', $orderCode);
    }

    /**
     * Scope để tìm kiếm theo mã giao dịch VNPay
     */
    public function scopeByVnpayTransactionNo($query, $transactionNo)
    {
        return $query->where('vnpay_transaction_no', $transactionNo);
    }
}
