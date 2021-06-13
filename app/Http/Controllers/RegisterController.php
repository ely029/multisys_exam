<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request = json_decode($request->getContent(), true);
        $request['auth_key'] = Str::random(60);
        $request['password'] = bcrypt($request['password']);
        $validator = Validator::make($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 401);
        }

        $check_user = User::where('email', $request['email'])->count();

        if ($check_user >= 1) {
            return response([
                'message' => 'User already registered',
            ], 401);
        }

        User::create($request);

        $data = ['message' => 'Users successfully registered'];

        return response()->json($data, 201);
    }
}
