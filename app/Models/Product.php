<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = []; 

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function getPriceChangePercentageAttribute()
    {
        $histories = $this->priceHistories()->latest()->take(2)->get();
        if ($histories->count() < 2) {
            return 0; // Tidak ada data perbandingan
        }

        $currentPrice = $histories[0]->price;
        $previousPrice = $histories[1]->price;

        if ($previousPrice == 0) return 0;

        $percentage = (($currentPrice - $previousPrice) / $previousPrice) * 100;
        return round($percentage, 1); // Dibulatkan 1 desimal
    }
}