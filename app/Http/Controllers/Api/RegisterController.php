<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if (config('auth.must_verify_email')) {
                event(new Registered($user));
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return response([
                'message' => 'Internal error, please try again later.', //$e->getMessage()
            ], 400);
        }
    }
}
