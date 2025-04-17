<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request) {
        $validatedData = $request->validated();
        
        if($user = $this->authService->createUser($validatedData)){
            return api_response()
                ->success()
                ->send(['access_token' => $this->authService->createUserToken($user)]);
        }
        return api_response()
                ->error()
                ->code(500)
                ->message('Failed to register user.')
                ->send();
    }

    public function login(LoginRequest $request)
    {
        if($user = $this->authService->login($request)){
            return api_response()
                ->success()
                ->send(['access_token' => $this->authService->createUserToken($user)]);
        }
        return api_response()
            ->error()
            ->code(400)
            ->message('Invalid login credentials')
            ->send();
    }

    public function logout()
    {
        return $this->authService->loggedOut() ? api_response()
                                                ->success()
                                                ->message('Logged out!')
                                                ->send()
                                                : 
                                                api_response()
                                                ->error()
                                                ->code(401)
                                                ->message('Not authenticated or already logged out!')
                                                ->send();
    }
}
