<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;

class FriendController extends Controller
{
    // Send friend request
    public function sendFriendRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = $request->user();
        $recipient = User::findOrFail($request->recipient_id);

        // Check if a friend request already exists
        if ($user->hasSentFriendRequestTo($recipient)) {
            return response()->json(['status' => false, 'message' => 'Friend request already sent'], 422);
        }

        // Send friend request
        $user->sentFriendRequests()->create([
            'friend_id' => $recipient->id,
            'status' => 'pending',
        ]);

        return response()->json(['status' => true, 'message' => 'Friend request sent successfully'], 200);
    }

    // Accept friend request
    public function acceptFriendRequest(Request $request, $id)
    {
        $user = $request->user();
        $friendRequest = Friend::where('friend_id', $user->id)
                               ->where('id', $id)
                               ->where('status', 'pending')
                               ->firstOrFail();

        // Accept friend request
        $friendRequest->update(['status' => 'accepted']);

        return response()->json(['status' => true, 'message' => 'Friend request accepted successfully'], 200);
    }

    // Cancel friend request
    public function cancelFriendRequest(Request $request, $id)
    {
        $user = $request->user();
        $friendRequest = Friend::where('user_id', $user->id)
                               ->where('id', $id)
                               ->where('status', 'pending')
                               ->firstOrFail();

        // Cancel friend request
        $friendRequest->delete();

        return response()->json(['status' => true, 'message' => 'Friend request canceled successfully'], 200);
    }

    // Remove friend
    public function removeFriend(Request $request, $id)
    {
        $user = $request->user();
        $friend = User::findOrFail($id);

        // Check if they are friends
        if (!$user->isFriendsWith($friend)) {
            return response()->json(['status' => false, 'message' => 'Not friends'], 422);
        }

        // Remove friend
        $user->friends()->detach($friend->id);

        return response()->json(['status' => true, 'message' => 'Friend removed successfully'], 200);
    }

    // Get pending friend requests
    public function getPendingFriendRequests(Request $request)
    {
        $user = $request->user();

        // Get pending friend requests
        $pendingRequests = $user->friendRequests()->with('user')->get();

        return UserResource::collection($pendingRequests);
    }
}
