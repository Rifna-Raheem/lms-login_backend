<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Find user by username
        $user = User::where('username', $request->username)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // 🔒 Teacher account status check
        if ($user->role === 'teacher' && $user->teacher->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Account is frozen or blocked'
            ], 403);
        }

        // Create Sanctum token
        $token = $user->createToken('login')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'role' => $user->role
        ]);
    }
}
