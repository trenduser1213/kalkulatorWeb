<?php
namespace App\Http\Controllers\AuthApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;


class Logincontroller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required','min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Membandingkan password yang sudah berbentuk hash
            if ($request->password === $user->password) {
                $token = JWTAuth::fromUser($user);
                // Masukkan token ke session
                Session::put('jwt_token', $token);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Success',
                    'token' => $token,
                ], 200)->header('Authorization', 'Bearer ' . $token);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wrong Password',
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 400);
        }
    }
}
