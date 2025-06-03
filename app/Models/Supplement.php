<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'bmi_category',
        'description',
        'price',
        'stock',
        'image',
        'expired_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expired_at' => 'date',
        ];
    }
    public function supplement()
    {
        return $this->belongsTo(Supplement::class, 'supplement_id');
    }
}
