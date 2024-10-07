<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\AuthRequest;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request) {
        $credentials = $request->only('email', 'password');
        if (!Auth::guard('karyawan')->attempt($credentials)) {
            return ApiResponseClass::throw('Authenticatication failed', 'Incorrect password', 401);
        }

        $user = Karyawan::where('email', $request->email)->first();

        $response['user_id'] = $user->id;
        $response['access_token'] = $user->createToken($request->email)->plainTextToken;
        
        return ApiResponseClass::sendResponse($response, 'Login successful', 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        
        
        return ApiResponseClass::sendResponse(null, 'You are logged out', 200);
    }
}
