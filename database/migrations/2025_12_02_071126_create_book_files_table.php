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
        Schema::create('book_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->string('file_path'); // Đường dẫn file trong storage
            $table->string('file_name'); // Tên file gốc
            $table->string('original_name'); // Tên file khi upload
            $table->integer('file_size'); // Kích thước file (bytes)
            $table->string('mime_type')->default('application/pdf'); // Loại file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_files');
    }
};
