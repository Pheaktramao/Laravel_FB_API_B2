<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'auth_id',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }

    public function getAllLike(){
        return $this->hasMany(Like::class, 'post_id');
    }
    // public function media(){
    //     return $this->hasMany(Medias::class, 'image_id', 'id');
    // }
    public function getComments()
    {
        return $this->hasMany(Comments::class);
    }

    
    public static function store($request, $id = null)
    {
        $data = $request->only('description','auth_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }

    public function getAllLike(){
        return $this->hasMany(Like::class, 'post_id');
    }

}
