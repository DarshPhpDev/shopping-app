<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * Retrieve all products with essential fields
     *
     * @return Collection<Product>
     */
    public function getAllProducts(int $perPage = 8): LengthAwarePaginator;

    /**
     * Update a product by its ID with validated data
     *
     * @param int $id The product ID
     * @param array $data Validated product data
     * @return Product
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function updateProduct(int $id, array $data): Product;

    /**
     * Find a product by its ID
     *
     * @param int $id The product ID
     * @return Product
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findProductById(int $id): Product;
}