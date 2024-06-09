<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return $this->errorResponse($validator->errors()->toArray(), ResponseAlias::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->email,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = Auth::login($user);

        return $this->successResponse(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "meta" => [
                "success" => true,
                "error" => [],
            ],
            "data" => [
                "token" => $token,
                "minutes_to_expire" => Auth::factory()->getTTL() * 60
            ]
        ]);
    }
}
