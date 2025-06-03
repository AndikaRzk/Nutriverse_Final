<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmiRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'height',
        'weight',
        'bmi',
        'bmi_category_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function category()
    {
        return $this->belongsTo(BmiCategory::class, 'bmi_category_id');
    }
}
