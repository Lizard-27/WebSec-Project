<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /** POST /api/users            → register */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required','string','min:3'],
            'email'    => ['required','email','unique:users,email'],
            'password' => ['required','string','min:6'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json($user, Response::HTTP_CREATED);
    }

    /** POST /api/login            → login */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($data)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Issue a personal access token:
        $tokenResult = $user->createToken('API Token');
        $token       = $tokenResult->accessToken;
        $expiresAt   = $tokenResult->token->expires_at->toDateTimeString();

        return response()->json([
            'user'       => $user,
            'access_token'=> $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt,
        ], Response::HTTP_OK);
    }

    /**
     * POST /api/logout
     * Revokes the current user’s token.
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logged out'
        ], Response::HTTP_OK);
    }


}
