<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUpdateRequest;
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

class ProductController extends Controller
{
    protected $productService;
    
    /**
     * Create a new ProductController instance.
     *
     * @param ProductServiceInterface $productService
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return api_response()
            ->success()
            ->send(['products' => $products]);
    }

    /**
     * Update the specified product.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        return api_response()
            ->success()
            ->message('Product updated successfully.')
            ->send(['product' => $product]);
    }
}