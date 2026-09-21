<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        $token = $user->createToken('furshield-web')->plainTextToken;

        return response()->json(['user'=>$user, 'token'=>$token], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'=>['required','email'],
            'password'=>['required','string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message'=>'Invalid credentials.'], 422);
        }

        $token = $user->createToken('furshield-web')->plainTextToken;

        return response()->json(['user'=>$user, 'token'=>$token]);
    }

    public function me(Request $request) { return response()->json($request->user()); }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message'=>'Logged out.']);
    }
}
