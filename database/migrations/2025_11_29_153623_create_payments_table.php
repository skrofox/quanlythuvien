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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            $table->foreignId('rental_id')->constrained("rentals")->cascadeOnDelete();
            $table->decimal("amount", 10, 2); // số tiền thanh toán
            $table->string("method"); // phương thức: momo, paypal, credit_card...
            $table->enum("status", ["pending", "paid", "failed", "refunded"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
