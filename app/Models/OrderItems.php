<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemsFactory> */
    use HasFactory;

     // Kolom yang boleh diisi secara massal
     protected $fillable = [
        'order_id',
        'supplement_id',
        'quantity',
        'price_at_purchase',
    ];

    // Tipe data casting untuk konversi otomatis
    protected $casts = [
        'price_at_purchase' => 'decimal:2',
    ];

    /**
     * Dapatkan pesanan yang memiliki item ini.
     */
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }


    /**
     * Dapatkan suplemen yang terkait dengan item ini.
     */
    public function supplement()
    {
        return $this->belongsTo(Supplement::class);
    }

}
