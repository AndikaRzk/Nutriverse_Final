<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    /** @use HasFactory<\Database\Factories\ChatsFactory> */
    use HasFactory;

    // Opsional: Secara eksplisit memberitahu Eloquent nama tabel jika tidak mengikuti konvensi (plural dari model plural)
    // Dalam kasus ini, jika model Chats, Eloquent akan mencari tabel 'chats' secara default, jadi ini tidak wajib.
    // protected $table = 'chats';

    protected $fillable = [
        'customer_id',
        'consultant_id',
    ];

    /**
     * Get the customer that owns the chat.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the consultant that owns the chat.
     */
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    /**
     * Get the messages for the chat.
     */
    public function messages()
    {
        // Perbaikan di sini: Menentukan foreign key secara eksplisit
        // Parameter kedua adalah nama foreign key di tabel 'messages'
        return $this->hasMany(Messages::class, 'chat_id');
    }
}
