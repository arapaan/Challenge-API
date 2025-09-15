<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:25'],
            'email'     => ['required', 'string', 'email', Rule::unique(Customer::class),],
            'password'  => ['required', 'min:8'],
        ]);

        $user = Customer::create([
            'name'
        ]);
    }
}
