<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookFile extends Model
{
    protected $table = "book_files";

    protected $fillable = [
        'book_id',
        'file_path',
        'file_name',
        'original_name',
        'file_size',
        'mime_type',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
