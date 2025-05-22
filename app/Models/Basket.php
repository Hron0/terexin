<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the basket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the basket.
     */
    public function items()
    {
        return $this->hasMany(BasketItem::class);
    }

    /**
     * Get the total price of all items in the basket.
     */
    public function getTotalPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Get the total number of items in the basket.
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }
}