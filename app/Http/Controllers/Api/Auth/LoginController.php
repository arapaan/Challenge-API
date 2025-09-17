<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => 'Error',
                'message' => 'Email atau Password salah'
            ], 401);
        }
    
        $user = Auth::user();
    
        // Hapus token lama biar gak numpuk
        $user->tokens()->delete();
    
        // Generate token baru + expired 1 jam
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;
    
        $tokenResult->accessToken->forceFill([
            'expires_at' => now()->addHour(),
        ])->save();
        
        return response()->json([
            'status'  => 'Success',
            'message' => 'Log-in Berhasil Dilakukan',
            'token'   => $token,
            'expires_at' => $tokenResult->accessToken->expires_at,
            'user'    => $user,
        ]);
    }

}
