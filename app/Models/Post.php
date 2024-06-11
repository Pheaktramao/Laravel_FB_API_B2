<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'auth_id',
        'tags',
        'image',
    ];

    public static function list($params)
    {
        return self::query();
    }

    public static function store($request, $id = null)
    {
        $data = $request->only('title', 'content', 'auth_id', 'tags', 'image');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
}
