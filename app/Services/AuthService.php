<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $model;
    
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * create new user using validated data
     * 
     * @param array $validatedData
     * @return Collection<User>
     */
    public function createUser(array $validatedData): User
    {
        return $this->model->create([
            'name'      => $validatedData['name'],
            'email'     => $validatedData['email'],
            'password'  => Hash::make($validatedData['password']),
        ]);
    }

    /**
     * create user access token
     * 
     * @param object $user
     * @return string token
     */
    public function createUserToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * Login User
     * 
     * @param object $user
     * @return false | user object
     */
    public function login(LoginRequest $request): mixed
    {
        // Using Auth::guard('web') since our current api guard using sanctum which doesn't have attempt method.
        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return false;
        }

        return $this->model->where('email', $request['email'])->first();        
    }

    /**
     * Logout User
     * 
     * @return bool
     */
    public function loggedOut(): bool
    {
        if($user = Auth::user()){
            $user->tokens()->delete();
            return true;
        }
        return false;
    }


}
