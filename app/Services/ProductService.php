<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService implements ProductServiceInterface {

    /**
     * The fields to select when retrieving products
     *
     * @var array
     */
    private const PRODUCT_FIELDS = ['id', 'title', 'price', 'category', 'image'];

    /**
     * Retrieve all products with essential fields
     *
     * @return Collection<Product>
     */
    public function getAllProducts(): Collection
    {
        return Product::select(self::PRODUCT_FIELDS)->get();
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