<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Images extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'profile_id'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * Store the uploaded image and associate it with a profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Images
     */
    public static function store(Request $request)
    {
        $image = new self();
        $image->profile_id = $request->input('profile_id');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            $image->image = $fileName;
        }

        $image->save();
        return $image;
    }
}