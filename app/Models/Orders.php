<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'customer_id',
        'order_number',
        'subtotal_amount',
        'tax_amount',
        'shipping_cost',
        'courier_commission_amount',
        'total_amount',
        'payment_status',
        'payment_gateway_ref',
        'delivery_address',
        'delivery_phone',
        'notes',
        'order_status',
        'courier_id',
    ];

    // Tipe data casting untuk konversi otomatis
    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'courier_commission_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Dapatkan pelanggan yang melakukan pesanan ini.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Dapatkan kurir yang ditugaskan untuk pesanan ini.
     */
    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    /**
     * Dapatkan semua item yang ada di dalam pesanan ini.
     */
    // Di model Order
public function orderItems()
{
    return $this->hasMany(OrderItems::class, 'order_id'); // ✅ BENAR
}




    /**
     * Dapatkan detail pengiriman yang terkait dengan pesanan ini.
     */
    public function delivery()
    {
        return $this->hasOne(Deliveries::class, 'order_id');
    }


// public function cartItems()
// {
//     return $this->hasMany(CartItems::class, 'order_id');
// }

    public function cartItems()
    {
        return $this->hasMany(CartItems::class,  'cart_id', 'id');
    }

}
