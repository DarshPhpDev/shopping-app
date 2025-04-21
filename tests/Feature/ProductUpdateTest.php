<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/products/';
    protected string $token;
    
    protected function setUp(): void
    {
        parent::setup();

        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->token = 'Bearer ' . $user->createToken('auth_token')->plainTextToken;
    }

    public function test_authenticated_user_can_update_a_product()
    {
        $product = Product::factory()->create();

        $payload = [
            'title'       => 'Updated Product Title',
            'description' => 'Updated description',
            'price'       => 199.99,
            'image'       => 'https://example.com/image.jpg',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->putJson($this->endpoint . $product->id, $payload);

        $response->assertOk()
                 ->assertJsonFragment(['title' => 'Updated Product Title']);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'title' => 'Updated Product Title']);
    }

    public function test_unauthenticated_user_cannot_update_a_product()
    {
        $product = Product::factory()->create();

        $payload = [
            'title'       => 'Should Not Update',
            'description' => 'No Auth',
            'price'       => 99.99,
            'image'       => 'https://example.com/fail.jpg',
        ];

        $response = $this->putJson($this->endpoint . $product->id, $payload);

        $response->assertStatus(401);
    }

    public function test_it_returns_validation_errors_for_invalid_payload()
    {
        $product = Product::factory()->create();

        $payload = [
            'title'       => '',
            'description' => '',
            'price'       => 'not-a-number',
            'image'       => 'not-a-url',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->putJson($this->endpoint . $product->id, $payload);

        $response->assertStatus(422)
                    ->assertJsonStructure([
                        'status' => [
                            'code',
                            'message',
                            'error',
                            'validation_errors' => [
                                'title',
                                'description',
                                'price',
                                'image',
                            ],
                        ],
                        'data'
                    ])
                    ->assertJsonFragment([
                        'code' => 422,
                        'message' => 'Validation Errors!',
                        'error' => true,
                    ]);
    }

    public function test_it_returns_not_found_for_invalid_product_id()
    {
        $payload = [
            'title'       => 'Will Not Work',
            'description' => 'Invalid ID',
            'price'       => 123,
            'image'       => 'https://example.com/404.jpg',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                         ->putJson($this->endpoint . 9999, $payload);

        $response->assertStatus(404);
    }
}

