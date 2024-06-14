<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'image',
        'auth_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }

    

    public function getAllLike(){
        return $this->hasMany(Like::class, 'post_id');
    }
}
