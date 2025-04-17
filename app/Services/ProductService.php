<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface {

    public function getAllProducts(): Collection
    {
        return Product::select('id', 'title', 'price', 'category', 'image')->get();
    }

    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }
}