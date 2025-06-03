<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Consultant extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'consultants';

    protected $fillable = [
        'name', 'gender', 'dob', 'specialization', 'email', 'password', 'phone', 'experience', 'price_per_session', 'is_available', 'available_from', 'available_to', 'is_online',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'dob' => 'date',
            'is_available' => 'boolean',
            'is_online' => 'boolean',
            'available_from' => 'datetime:H:i:s',
            'available_to' => 'datetime:H:i:s',
            'price_per_session' => 'decimal:2',
        ];
    }
}
