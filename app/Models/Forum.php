<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forum extends Model
{
    protected $fillable=['ForumTitle','ForumImage','ForumContent','ForumCreator','CreatedAt'];
    protected $guarded=['ForumID'];
    protected $primaryKey='ForumID';
    public function forumpost():HasMany
    {
        return $this->hasMany(Forumposts::class);
    }

    public function creator()
    {
        return $this->belongsTo(Customer::class, 'ForumCreator');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'ForumCreator', 'id');
    }

    // use HasFactory;
}
