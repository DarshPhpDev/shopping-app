<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceInterface{
    public function getAllProducts(): Collection;
    public function updateProduct(int $id, array $data): Product;
}