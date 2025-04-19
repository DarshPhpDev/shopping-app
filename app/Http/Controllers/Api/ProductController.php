<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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