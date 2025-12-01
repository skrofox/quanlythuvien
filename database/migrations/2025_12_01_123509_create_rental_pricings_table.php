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
        Schema::create('rental_pricings', function (Blueprint $table) {
            $table->id();
            $table->integer('period_days'); // Số ngày mượn: 7, 14, 30, 365
            $table->string('name'); // Tên gói: "7 ngày", "14 ngày", "1 tháng", "1 năm"
            $table->decimal('price', 10, 2); // Giá mượn
            $table->text('description')->nullable(); // Mô tả
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_pricings');
    }
};
