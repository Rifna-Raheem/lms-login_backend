<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Find user by username and password
        $user = DB::table('users')
            ->where('username', $request->username)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            // If user found, return role
            return response()->json([
                'success' => true,
                'role' => $user->role
            ]);
        }

        // If login fails
        return response()->json([
            'success' => false
        ], 401);
    }
}
