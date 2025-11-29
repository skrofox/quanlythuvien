<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";

    protected $fillable = [
        "user_id",
        "rental_id",
        "amount",
        "method",
        "status",
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function rental(){
        return $this->belongsTo(Rentals::class, "rental_id", "id");
    }
}
