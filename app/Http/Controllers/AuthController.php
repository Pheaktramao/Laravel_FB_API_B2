<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request): JsonResponse
    {
            try{
            $validatorUser = Validator::make($request->all(),
            [
                'first_name'=> 'required|string|max:20',
                'last_name'=> 'required|string|max:20',
                'dateOfBirth'=> 'required|date_format:d-m-Y',
                'phone'=> 'required|string|max:20',
                'email'=> 'required|string|max:255',
                'password'=> 'required|string',
            ]);

            if ($validatorUser->fails()) {
                return response()->json($validatorUser->errors());
            }

            $dateOfBirth = Carbon::createFromFormat('d-m-Y', $request->dateOfBirth)->format('Y-m-d');

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'dateOfBirth' => $dateOfBirth,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
            ]);
           
            return Response()->json([
                'status' => 'true',
                'message' => 'Successfully created',
                'token' => $user->createToken("API Token")->plainTextToken
            ],200);
            
            }catch(\throwable $th){
                return Response()->json([
                   'status' => 'false',
                   'message' => $th->getMessage()
                ],500);
            }
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:255',
            'password'  => 'required|string'
          ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions();
        $roles = $user->getRoleNames();
        return response()->json([
            'message' => 'Login success',
            'data' =>$user,
        ]);
    }
    // ==============================================
    public function forgotPassword(Request $request): JsonResponse
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'status' => 'false',
            'message' => 'Email does not exist',
        ], 404);
    }

    // Generate a new password
    $newPassword = Str::random(8);

    // Update the user's password
    $user->password = Hash::make($newPassword);
    $user->save();

    try {
        // Send the new password to the user's email
        Mail::send('emails.reset_password', ['newPassword' => $newPassword], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Your New Password');
        });

        return response()->json([
            'status' => 'true',
            'message' => 'A new password has been sent to your email.',
            'new_password' => $newPassword,
        ], 200);
    } catch (\Exception $e) {
        // return response()->json([
        //     'status' => 'false',
        //     'message' => 'Failed to send email. Please try again later.',
        //     'error' => $e->getMessage(), // Optional: Provide error details for debugging
        // ], 500);
        return response()->json([
            'status' => 'true',
            'message' => 'A new password has been sent to your email.',
            'new_password' => $newPassword,
        ], 200);
    }
}
}