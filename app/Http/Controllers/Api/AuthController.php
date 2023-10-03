<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                /** @var User $user */
                $user = Auth::user();
                $token = $user->createToken('API Token')->accessToken;

                if (config('auth.must_verify_email') && ! $user->hasVerifiedEmail()) {
                    return response([
                        'message' => 'Email must be verified.',
                    ], 401);
                }

                return response([
                    'message' => 'success',
                    'token' => $token,
                    'user' => $user,
                ]);
            }
        } catch (\Exception $e) {
            return response([
                'message' => 'Internal error, please try again later.', //$e->getMessage()
            ], 400);
        }

        return response([
            'message' => 'Invalid Email or password.',
        ], 401);
    }

    public function user()
    {
        return response()->json(Auth::user());
    }
}
