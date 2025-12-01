<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPricing extends Model
{
    protected $table = "rental_pricings";

    protected $fillable = [
        "period_days",
        "name",
        "price",
        "description",
        "is_active",
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function rentals(){
        return $this->hasMany(Rentals::class, "rental_pricing_id", "id");
    }
}
