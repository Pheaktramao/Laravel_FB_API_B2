<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function Addlike(Request $request){
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);
        $like = Like::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id()
        ]);
        return response("Liked", 200);


    }

    public function Unlike(Request $request){
        $request->validate([
            'post_id' =>'required|exists:posts,id',

        ]);

        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = Like::where('post_id', $post_id)->where('user_id', $user_id)->first();

        if ($like) {
            # code...
            $like->delete();
            return response("Unliked", 200);
        }else{
            return response("Cannot like this post", 404);
        }
    }
}
