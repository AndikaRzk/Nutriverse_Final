<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemsFactory> */
    use HasFactory;
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'cart_id',
        'supplement_id',
        'quantity',
    ];

    /**
     * Dapatkan keranjang yang memiliki item ini.
     */
    public function cart()
    {
        return $this->belongsTo(Carts::class);
    }

    /**
     * Dapatkan suplemen yang terkait dengan item ini.
     */
    public function supplement()
    {
        return $this->belongsTo(Supplement::class);
    }
}
