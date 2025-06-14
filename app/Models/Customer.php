<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'customers';

    protected $fillable = [
        'name', 'gender', 'dob', 'email', 'password', 'phone', 'address'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }


// public function cart()
// {
//     return $this->hasOne(Carts::class);
// }

/**
     * Get the chats for the customer.
     */
    public function chats()
    {
        return $this->hasMany(Chats::class);
    }

    /**
     * Get the messages sent by the customer.
     */
    public function messages()
    {
        return $this->morphMany(Messages::class, 'sender');
    }
}
