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
    
    public function __construct(ProductServiceInterface $productService){
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return api_response()
            ->success()
            ->send(['products' => $products]);
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        return api_response()
            ->success()
            ->message('Product updated successfully.')
            ->send(['product' => $product]);
    }
}