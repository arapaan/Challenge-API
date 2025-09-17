<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:25'],
            'email'     => ['required', 'string', 'email', Rule::unique(User::class),],
            'password'  => ['required', 'min:8'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;

        $tokenModel = $tokenResult->accessToken;
        $tokenModel->expires_at = Carbon::now()->addHour();
        $tokenModel->save();

        return response()->json([
            'status'    => true,
            'message'   => 'User Berhasil Dibuat',
            'data'      => $user,
            'token'     => $token,
        ], 201);
    }
}
