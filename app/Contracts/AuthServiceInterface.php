<?php

namespace App\Contracts;

use App\Http\Requests\LoginRequest;
use App\Models\User;

interface AuthServiceInterface
{

    /**
     * create new user using validated data
     * 
     * @param array $validatedData
     * @return Collection<User>
     */
    public function createUser(array $validatedData): User;

    /**
     * create user access token
     * 
     * @param object $user
     * @return string token
     */
    public function createUserToken(User $user): string;

    /**
     * Login User
     * 
     * @param object $user
     * @return false | user object
     */
    public function login(LoginRequest $request): mixed;

    /**
     * Logout User
     * 
     * @return bool
     */
    public function loggedOut(): bool;
}