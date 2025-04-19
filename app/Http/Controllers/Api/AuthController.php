<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/* 
    Dev Notes:-
        Laravel Api Resource could have been used to unify api response for each model
        But since the project is very simple, I didn't use it to avoid unnecessary complications.
        For api response format I'm using my own laravel package that I use in all api based projects.
        Laravel API Response Formatter (https://github.com/DarshPhpDev/laravel-api-response-formatter)
        Used like: return api_response()
                        ->success()
                        ->code(200)
                        ->message('Successfully registered.');

        Applying Single Responsibility Princible by using service layer to seprate business layer and keep the controllers clean handling request/response only.

        Applying Dependency Inversion by depending on abstraction (Interfaces) instead of concrete service implementation
        with the help of laravel dependency injection and service containers, I've registered concrete implementations 
        of each interface in AppServiceProvider as $bindings array.

*/

class AuthController extends Controller
{
    protected $authService;

    /**
     * Create a new ProductController instance.
     *
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }

    /**
     * Create new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse with access_token
     */
    public function register(RegisterRequest $request): JsonResponse{
        $validatedData = $request->validated();
        
        if($user = $this->authService->createUser($validatedData)){
            return api_response()
                ->success()
                ->message('Successfully registered.')
                ->send(['access_token' => $this->authService->createUserToken($user)]);
        }
        return api_response()
                ->error()
                ->code(500)
                ->message('Failed to register user.')
                ->send();
    }

    /**
     * Login User.
     *
     * @param LoginRequest $request
     * @return JsonResponse with access_token
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if($user = $this->authService->login($request)){
            return api_response()
                ->success()
                ->message('Successfully Logged In.')
                ->send(['access_token' => $this->authService->createUserToken($user)]);
        }
        return api_response()
            ->error()
            ->code(400)
            ->message('Invalid login credentials')
            ->send();
    }

    /**
     * Logout User.
     *
     * @return JsonResponse with 200 status | 401 authenticated 
     */
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
