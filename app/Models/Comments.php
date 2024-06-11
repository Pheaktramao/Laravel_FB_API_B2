<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'post_id',
        'user_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function list($params)
    {
        return self::query();
    }

    public static function store($request, $id = null)
    {
        $data = $request->only('text', 'post_id', 'user_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
}
