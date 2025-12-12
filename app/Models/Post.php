<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = [
        "title",
        "slug",
        "summary",
        "content",
        "image",
        "user_id",
        "status",
        "views",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, "post_category", "post_id", "category_id");
    }
}
