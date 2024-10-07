<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Enum\KaryawanStatus;
use App\Http\Requests\AuthRequest;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request) {
        $credentials = $request->only('email', 'password');
        // die(Auth::guard('api')->attempt($credentials));
        if (!Auth::attempt($credentials)) {
        // if (!auth()->guard('api')->attempt($credentials)) {
            die('$userr');
            return ApiResponseClass::throw('Authenticatication failed', 'Incorrect password', 401);
        }

        // die('$user');
        // $user = Auth::getDefaultDriver();
        // die($user);
        $user = Karyawan::where('email', $request->email)->first();
        $user->status = KaryawanStatus::AKTIF->value;
        $user->save();

        $response['user_id'] = $user->id;
        $response['access_token'] = $user->createToken($request->email)->plainTextToken;
        
        return ApiResponseClass::sendResponse($response, 'Login successful', 201);
    }

    public function logout(Request $request) {
        /** @var \App\Models\Karyawan $user **/
        // $user = Auth::getDefaultDriver();
        // die($user);
        $user = Auth::user();
        $user->status = KaryawanStatus::NONAKTIF->value;
        $user->save();

        $request->user()->currentAccessToken()->delete();
        
        return ApiResponseClass::sendResponse(null, 'You are logged out', 200);
    }
}
