<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmiCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'min_value',
        'max_value',
    ];

    public function bmiRecords()
    {
        return $this->hasMany(BmiRecord::class);
    }
}
