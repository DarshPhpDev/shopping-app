<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Auth;

class AuthService implements AuthServiceInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function createUser($validatedData): User
    {
        return $this->model->create([
            'name'      => $validatedData['name'],
            'email'     => $validatedData['email'],
            'password'  => Hash::make($validatedData['password']),
        ]);
    }

    public function createUserToken($user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function login($request): mixed
    {
        // Using Auth::guard('web') since our current api guard using sanctum which doesn't have attempt method.
        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return false;
        }

        return $this->model->where('email', $request['email'])->first();        
    }

    public function loggedOut(): bool
    {
        if($user = Auth::user()){
            $user->tokens()->delete();
            return true;
        }
        return false;
    }
}
