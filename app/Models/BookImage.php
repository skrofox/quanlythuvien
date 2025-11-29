<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    protected $table = "book_images";

    protected $fillable = [
        'book_id',
        'url',
    ];

    public function book(){
        return $this->belongsTo(Book::class, "book_id", "id");
    }
}
