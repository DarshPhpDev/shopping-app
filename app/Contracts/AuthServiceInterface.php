<?php

namespace App\Contracts;

use App\Models\Product;
use App\Models\User;

interface AuthServiceInterface{
    public function createUser($validatedData): User;
    public function createUserToken($user): string;
    public function login($request): mixed;
    public function loggedOut(): bool;
}