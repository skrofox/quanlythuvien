<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = [
        "name",
        "slug",
        "description",
    ];

    public function books(){
        return $this->belongsToMany(Book::class, "book_category", "category_id", "book_id");
    }

    public function posts(){
        return $this->belongsToMany(Post::class, "post_category", "category_id", "post_id");
    }
}
