<?php

namespace App\Http\Controllers;

use App\Models\LogoutLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
//  /**
//      * @OA\Post(
//      *     path="/api/auth/register",
//      *     tags={"Register"},
//      *     summary="Register a new user",
//      *     @OA\RequestBody(
//      *         @OA\JsonContent(
//      *             type="object",
//      *             @OA\Property(property="first_name", type="string"),
//      *             @OA\Property(property="last_name", type="string"),
//      *             @OA\Property(property="phone", type="string"),
//      *             @OA\Property(property="dateOfBirth", type="string"),
//      *             @OA\Property(property="email", type="string"),
//      *             @OA\Property(property="password", type="string"),
//      *         )
//      *     ),
//      *     @OA\Response(
//      *         response=201,
//      *         description="Successful response",
//      *         @OA\JsonContent(
//      *             type="object",
//      *             @OA\Property(property="message", type="string"),
//      *             @OA\Property(property="accessToken", type="string")
//      *         )
//      *     )
//      * )
//      */
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
            ], 200);
        } catch (\throwable $th) {
            return Response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
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
            'user'=> $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    // public function index(Request $request)
    // {
    //     $user = $request->user();
    //     $permissions = $user->getAllPermissions();
    //     $roles = $user->getRoleNames();
    //     return response()->json([
    //         'message' => 'Login success',
    //         'data' =>$user,
    //     ]);
    // }

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function index(Request $request)
    {
        return response()->json($request->user());
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // LogoutLog::create([
        //     'user_id' => $request->user()->id,
        //     // 'logged_out_at' => now()
        // ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Successfully logged out'
        ]);
    }
}

