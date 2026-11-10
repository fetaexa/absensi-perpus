<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'regex:/^[^@\s]+@student\.stembayo\.sch\.id$/i',
            ],
            'password' => ['required', 'string'],
        ]);

        if (! hash_equals((string) config('services.stembayo.password'), $validated['password'])) {
            return response()->json(['message' => 'Email atau password salah.'], 422);
        }

        $email = Str::lower($validated['email']);
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => Str::before($email, '@'),
                'password' => $validated['password'],
            ],
        );

        $user->profile()->firstOrCreate([]);
        $token = $user->createToken('frontend', ['*'], now()->addDays(30))->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => ['email' => $user->email],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['status' => 'success']);
    }
}
