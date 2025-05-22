<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCharacteristic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'screen',
        'processor',
        'ram',
        'battery',
        'os',
    ];

    /**
     * Get the product that owns the characteristics.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}