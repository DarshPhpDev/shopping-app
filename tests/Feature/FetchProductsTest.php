<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class FetchProductsTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/products/';

    public function test_it_returns_products_after_running_import_command()
    {
        $this->artisan('products:import')->assertExitCode(0);

        $response = $this->getJson($this->endpoint);
     
        $response->assertOk()
                        ->assertJsonStructure([
                            'status' => [
                                'code',
                                'message',
                                'error',
                                'validation_errors'
                            ],
                            'data' => [
                                'products'  => [
                                    [
                                        'id',
                                        'title',
                                        'price',
                                        'category',
                                        'image'
                                    ]
                                ]
                            ]
                        ]);
    }
}

