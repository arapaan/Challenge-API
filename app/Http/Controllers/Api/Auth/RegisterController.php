<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\User;

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
            'password'  => $request->password
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'    => true,
            'message'   => 'User Berhasil Dibuat',
            'data'      => $user,
            'token'     => $token,
        ], 201);
    }
}
