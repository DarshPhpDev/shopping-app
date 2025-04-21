<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface {
    
    /**
     * Retrieve all products with essential fields
     *
     * @return LengthAwarePaginator
     */
    public function getAllProducts(int $perPage = 8): LengthAwarePaginator
    {
        return Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'products.id',
                'products.title',
                'products.price',
                'products.image',
                'categories.name as category',
            ])
            ->orderBy('products.id')
            ->paginate($perPage);
    }

    /**
     * Update a product by its ID with validated data
     *
     * @param int $id The product ID
     * @param array $data Validated product data
     * @return Product
     */
    public function updateProduct(int $id, array $data): Product
    {
        $product = $this->findProductById($id);
        $product->update($data);
        return $product;
    }

    /**
     * Find a product by its ID
     *
     * @param int $id The product ID
     * @return Product
     * @throws ModelNotFoundException
     */
    public function findProductById(int $id): Product
    {
        return Product::findOrFail($id);
    }
}