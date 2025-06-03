<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveriesFactory> */
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'order_id',
        'courier_id',
        'delivery_status',
        'pickup_at',
        'delivered_at',
        'delivery_notes',
        'proof_of_delivery_image',
    ];

    // Tipe data casting untuk konversi otomatis
    protected $casts = [
        'pickup_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Dapatkan pesanan yang terkait dengan pengiriman ini.
     */
    // public function order()
    // {
    //     return $this->belongsTo(Orders::class);
    // }

    /**
     * Dapatkan kurir yang menangani pengiriman ini.
     */
    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function order()
{
    return $this->belongsTo(Orders::class, 'order_id');
}
}
