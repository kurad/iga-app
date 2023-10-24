<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api',['except'=>['login', 'register']]);
    // }
    public function login(Request $request)
    {
        $creadentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if(auth()->attempt($creadentials)){
            $user = Auth::user();
            $user['token'] = $user->createToken('bigStore')->accessToken;
            return response()->json([
                'user' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ],402);
    }
    public function signin(Request $request)
        {
            $status = 401;
            $response = ['error' => 'Unauthorised'];

            if (Auth::attempt($request->only(['email', 'password']))) {
                $status = 200;
                $response = [
                    'user' => Auth::user(),
                    'token' => Auth::user()->createToken('bigStore')->plainTextToken,
                ];
            }

            return response()->json($response, $status);
        }

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'phone' => 'nullable|max:10',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'school_id' => 'required',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'school_id' => $request->school_id,
        ]);
        return response()->json([
            'message' => 'User Registered successfully',
            'user' => $user
        ]);
    }
    public function getUser()
    {
        $user = auth()->user();
        return response()->json($user, 200);
    }
        public function logout()
        {
        Auth::user()->tokens()->delete();
        return response()->json([
        'message' => 'Successfully logged out',
        ]);
        }

        
}