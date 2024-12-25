<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::query()->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'role' => $validatedData['role'],
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);


    }

    /**
     * @throws ValidationException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::query()->where('email', $validatedData['email'])->first();


        if (!JWTAuth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'message' => 'Предоставленные учетные данные неверны.',
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);
    }


    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
