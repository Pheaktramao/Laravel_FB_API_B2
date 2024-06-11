<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentListResource;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comments::all();
        $comment = CommentListResource::collection($comment);
        return response(['success' => true, 'data' =>$comment], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comments::create($request->all());
        return response(['success' => true, 'data' =>$comment], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comments::find($id);
        return response(['success' => true, 'data' =>$comment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Comments::store($request,$id);
        return ["success" => true, "Message" =>"Comment updated successfully"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comments::destroy($id);
        return ["success" => true, "Message" =>"Comment deleted successfully"];
    }
}
