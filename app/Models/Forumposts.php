<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Forumposts extends Model
{
    /** @use HasFactory<\Database\Factories\ForumpostsFactory> */
    // use HasFactory;
    protected $primaryKey = 'PostID';

public $incrementing = true;

protected $keyType = 'int';

    protected $fillable=['commentcontent','ForumID','Username','CreatedAt','userid'];
    // public function forum():HasOne
    // {
    //     return $this->hasOne(Forum::class);
    // }

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'ForumID', 'ForumID');
    }

    // hubungan ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerid', 'id');
    }
}
