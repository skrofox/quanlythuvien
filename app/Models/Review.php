<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = "reviews";

    protected $fillable = [
        "user_id",
        "book_id",
        "rating",
        "comment",
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function book(){
        return $this->belongsTo(Book::class, "book_id", "id");
    }
}
