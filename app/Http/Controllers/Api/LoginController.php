<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = validator::make($request->all(),[
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], 422);
        }        
        
    }
}
