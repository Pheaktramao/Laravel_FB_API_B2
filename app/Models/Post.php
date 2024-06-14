<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'image',
        'auth_id',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class);
    }

    
    public static function store($request, $id = null)
    {
        $data = $request->only('description', 'image', 'auth_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
}
