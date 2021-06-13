<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request = json_decode($request->getContent(), true);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response([
                'access_token' => Auth::user()->auth_key,
            ], 201);
        } else {
            return response([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }
}
