<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostListResource;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        $post = PostListResource::collection($post);
        return response(['success' => true, 'data' =>$post], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addPost(Request $request)
    {
        $request->validate([
            "image"=>'required',
            "description"=>'required',
        ]);
        $post = Post::create([
            'image'=>$request->image,
            'description'=>$request->description,
            'auth_id'=>Auth()->user()->id,
        ]);
        // Post::store($request);
        return [
            'success' =>true,
            'data' =>$post,
            'message' =>"Post created successfully"
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::show($id);
        return [
            'success' => true,
            'data'=> $post,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Post::store($request,$id);
        return [
            "success" => true, 
            "Message" =>"Post updated successfully"
        ];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);
        return [
            "success" => true, 
            "Message" =>"Post deleted successfully"
    ];
    }


    // public function likePost(Request $request){
    //     $request->validate([
    //         'post_id'=> 'required',

    //     ]);
    //     $like = Like::create([
    //         'post_id'=> $request->post_id,
    //         'user_id'=> Auth()->user()->id,
    //     ]);
    //     return response("Liked");
    // }
}
