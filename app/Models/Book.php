<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $table = "books";

    protected $fillable = [
        "name",
        "author",
        "publisher",
        "year",
        "slug",
    ];

    public function images(){
        return $this->hasMany(BookImage::class, "book_id", "id");
    }

    public function categories(){
        return $this->belongsToMany(Category::class, "book_category", "book_id", "category_id");
    }
}
