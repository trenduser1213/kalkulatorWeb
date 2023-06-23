<?php
namespace App\Http\Controllers\AuthApi;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Session;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LogoutController extends Controller
{
    

public function logout()
{
    try {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::parseToken();

        // Verifikasi validitas token
        if (!$token->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token',
            ], 401);
        }

        // Menghapus token dari daftar token yang valid
        JWTAuth::invalidate($token); 

        // Menghapus token dari session (opsional)
        Session::remove('jwt_token');

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ], 200);
    } catch (JWTException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to logout',
        ], 500);
    }
}

}