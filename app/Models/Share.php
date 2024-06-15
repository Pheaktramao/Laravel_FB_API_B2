<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Share extends Model
{
    use HasFactory,SoftDeletes;

    

    public static function store($request, $id = null)
    {
        $data = $request->only('description', 'post_id', 'auth_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
}
