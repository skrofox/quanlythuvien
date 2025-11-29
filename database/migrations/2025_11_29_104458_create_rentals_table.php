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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users")->cascadeOnDelete();
            $table->foreignId('book_id')->constrained("books")->cascadeOnDelete();
            $table->dateTime("rented_at"); //ngay thue sach
            $table->dateTime("due_at"); //han tra sach
            $table->dateTime("returned_at")->nullable(); //ngay tra thuc te
            $table->enum("status", ["pending", "active", "returned", "late"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
