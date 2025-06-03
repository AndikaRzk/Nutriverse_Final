<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    /** @use HasFactory<\Database\Factories\CartsFactory> */
    use HasFactory;
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Dapatkan semua item yang ada di dalam keranjang ini.
     */
    // public function cartItems()
    // {
    //     return $this->hasMany(CartItems::class);
    // }

    public function cartItems()
    {
        return $this->hasMany(CartItems::class, 'cart_id');
    }
}
