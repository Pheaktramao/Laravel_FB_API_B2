<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "bio" => 'required',
            "date_of_birth" => 'required',
        ]);

        $profile = Profile::create([
            'bio' => $request->bio,
            'date_of_birth' => $request->date_of_birth,
            'user_id' => Auth()->user()->id,
        ]);

        return new ProfileResource($profile);
    }
    
    public function show(string $id)
    {
        $profile = Profile::find($id);
        return response(['success' => true, 'data' => $profile], 200);
    }
}