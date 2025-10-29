<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CourierAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $courier = Courier::where('username', $request->username)->first();

        if (!$courier || !Hash::check($request->password, $courier->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $courier->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'courier' => $courier
        ]);
    }
}
