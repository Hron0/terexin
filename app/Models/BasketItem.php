<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'basket_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the basket that owns the item.
     */
    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }

    /**
     * Get the product that the item refers to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subtotal for this item.
     */
    public function getSubtotalAttribute()
    {
        return $this->product->price * $this->quantity;
    }
}