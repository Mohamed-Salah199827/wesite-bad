<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:5|max:30|confirmed',
            'password_confirmation' => 'required',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|numeric|min:11',
            'city' => 'nullable|string',
            'country' => 'nullable|string'

        ]);
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = Role::where('name', 'user')->first()->id;
        $data['access_token'] = Str::random(64);
        $user = User::create($data);
        header("location:http://127.0.0.1:8000/api/register");
        return response()->json([
            'access_token' => $data['access_token'],
            'user' => $user,
            'success_msg' => 'Registered',
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:5|max:30',
        ]);
        $isLogin = auth()->attempt(['email' => $data['email'], 'password' => $data['password']]);
        if (!$isLogin) {
            return response()->json([
                'error_msg' => 'Please check your password and e-mail',
            ], 422);
        }
        $accessToken = Str::random(64);
        auth()->user()->update([
            'access_token' => $accessToken,
        ]);
        $user = auth()->user();
        return response()->json([
            'access_token' => $accessToken,
            'user' => $user,
            'success_msg' => 'Login',
        ]);
        header('Access-Control-Allow-Origin:*');
    }

    public function logout(Request $request)
    {
        return response()->json($request->headers());

        $accessToken = $request->header('Access-Token');
        User::where('access_token', $accessToken)->first()->update([
            'access_token' => null,
        ]);
        return response()->json([
            'success_msg' => 'logout',
        ]);
    }
    public function allUser(){
        $allUser=User::all();
        return response()->json([
            'user' => $allUser,
        ]);

    }
}
