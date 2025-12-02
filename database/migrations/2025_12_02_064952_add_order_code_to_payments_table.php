<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('order_code')->unique()->nullable()->after('id'); // Mã đơn hàng (vnp_TxnRef)
            $table->string('vnpay_transaction_no')->nullable()->after('order_code'); // Mã giao dịch từ VNPay
            $table->string('vnpay_bank_code')->nullable()->after('vnpay_transaction_no'); // Mã ngân hàng
            $table->timestamp('vnpay_pay_date')->nullable()->after('vnpay_bank_code'); // Ngày thanh toán từ VNPay
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['order_code', 'vnpay_transaction_no', 'vnpay_bank_code', 'vnpay_pay_date']);
        });
    }
};
