<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $request->validate(
            [
                "name" => "required",
                "email" => "required|email|unique:users",
                "password" => "required|min:8",
            ],
            $request->input()
        );

        $request["password"] = Hash::make($request['password']);

        $user = User::create(
            $request->only(["name", "email", "password"])
        );

        return response()->json(
            [
                "status" => true,
                "data" => [
                    "user" => $user,
                ],
                "message" => "Registration has been completed.",
            ]
        );
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                "email" => "required|email",
                "password" => "required",
            ]
        );
        
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                "status" => false,
                "data" => [],
                "message" => "Unable to find user with given details",
            ]);
        }

        return response()->json(
            [
                "status" => true,
                "data" => [
                    "user" => auth()->user(),
                    "token" => auth()->user()->createToken('auth_token')->plainTextToken
                ],
                "message" => "Login has been done successfully.",
            ]
        );
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(
            [
                "status" => true,
                "data" => [],
                "message" => "User has been logged out successfully.",
            ]
        );
    }

}
