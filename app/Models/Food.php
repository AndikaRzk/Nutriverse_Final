<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'name',
        'category',
        'meal_time',
        'bmi_category',
        'portion_size_grams',
        'calories',
        'protein_g',
        'carbs_g',
        'fat_g',
    ];

    // Casting enum supaya bisa langsung dapat string yang valid dan validasi otomatis
    protected $casts = [
        'meal_time' => 'string',      // enum('breakfast', 'lunch', 'dinner')
        'bmi_category' => 'string',   // enum('underweight', 'normal', 'overweight', 'obese')
        'portion_size_grams' => 'integer',
        'calories' => 'integer',
        'protein_g' => 'float',
        'carbs_g' => 'float',
        'fat_g' => 'float',
    ];
}
