<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    protected $table = "rentals";

    protected $fillable = [
        "user_id",
        "book_id",
        "rental_pricing_id",
        "rented_at",
        "due_at",
        "returned_at",
        "status",
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function book(){
        return $this->belongsTo(Book::class, "book_id", "id");
    }

    public function payments(){
        return $this->hasMany(Payment::class, "rental_id", "id");
    }

    public function rentalPricing(){
        return $this->belongsTo(RentalPricing::class, "rental_pricing_id", "id");
    }
}
