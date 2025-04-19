<?php

namespace App\Providers;

use App\Contracts\AuthServiceInterface;
use App\Contracts\ProductServiceInterface;
use App\Services\AuthService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /* 
        Register bindings to be resolved in Controller constructors.
        so when we pass AuthServiceInterface $authService it should be resolved as an object of AuthService
    */
    public $bindings = [
        AuthServiceInterface::class => AuthService::class,
        ProductServiceInterface::class => ProductService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
