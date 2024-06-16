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
        $comments = Comments::all();
        return response()->json(['success' => true, 'data' => $comments], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addComment(Request $request)
    {
        $request->validate([
            "text" => 'required',
            "post_id" => 'required',
        ]);
        $comment = Comments::store([
            'text' => $request->text,
            'post_id' => $request->post_id,
            'user_id' => Auth()->user()->id,
        ]);

        return [
            'success' => true,
            'message' => "Comment created successfully"
        ];
    }

    /**
     * Display the specified resource.
     */
    public function getComment(string $id)
    {
        $comment = Comments::find($id);
        return response(['success' => true, 'data' => $comment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateComment(Request $request, string $id)
    {
        Comments::store($request, $id);
        return ["success" => true, "Message" => "Comment updated successfully"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comments::destroy($id);
        return ["success" => true, "Message" => "Comment deleted successfully"];
    }
}
