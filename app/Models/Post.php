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


    // public static function store($request, $id = null)
    // {
    //     $data = $request->only('description', 'image', 'auth_id');
    //     $data = self::updateOrCreate(['id' => $id], $data);
    //     return $data;
    // }

    // public static function show($id){
    //     $data = self::find($id);
    //     return $data;
    // }
    
    // public static function destroy($id){
    //     $data = self::find($id);
    //     $data->delete();
    //     return $data;
    // }
}
