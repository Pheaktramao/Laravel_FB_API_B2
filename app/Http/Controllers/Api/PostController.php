<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostListResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listPost()
    {
        $post = Post::all();
        $post = ShowPostResource::collection($post);
        return response(['success' => true, 'Posts' => $post], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addPost(Request $request)
    {
        $request->validate([
            "image" => 'required',
            "description" => 'required',
        ]);
        $post = Post::create([
            'image' => $request->image,
            'description' => $request->description,
            'auth_id' => Auth()->user()->id,
        ]);
        // Post::store($request);
        return [
            'success' => true,
            'data' => $post,
            'message' => "Post created successfully"
        ];
    }

    /**
     * Display the specified resource.
     */
    public function getPost($id)
    {
        $post = Post::find($id);
        $post = new ShowPostResource($post);
        return [
            'success' => true,
            'Posts' => $post,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePost(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return [
           'success' => true,
            'data' => $post,
           'message' => "Post updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return [
           'success' => true,
           'message' => "Post deleted successfully"
        ];
    }


}
