<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $postId)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Find the post
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Check if the user has already liked the post
        $like = Like::where('post_id', $postId)
            ->where('user_id', $request->user_id)
            ->first();

        if ($like) {
            return response()->json(['message' => 'Post already liked'], 400);
        }

        // Create a new like
        $like = new Like();
        $like->post_id = $postId;
        $like->user_id = $request->user_id;
        $like->save();

        return response()->json(['message' => 'Post liked successfully']);
    }
}
