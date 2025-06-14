<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    /** @use HasFactory<\Database\Factories\MessagesFactory> */
    use HasFactory;

    // Opsional: Secara eksplisit memberitahu Eloquent nama tabel jika tidak mengikuti konvensi (plural dari model plural)
    // Dalam kasus ini, jika model Messages, Eloquent akan mencari tabel 'messages' secara default, jadi ini tidak wajib.
    // protected $table = 'messages';

    protected $fillable = [
        'chat_id',
        'sender_id',
        'sender_type',
        'message',
        'file_path',
        'file_type',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the chat that the message belongs to.
     */
    public function chats()
    {
        // Perbaikan di sini: Menentukan foreign key secara eksplisit
        // Parameter kedua adalah nama foreign key di tabel 'messages'
        return $this->belongsTo(Chats::class, 'chat_id');
    }

    /**
     * Get the parent sender model (Customer or Consultant).
     */
    public function sender()
    {
        return $this->morphTo();
    }
}
