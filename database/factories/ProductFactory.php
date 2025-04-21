<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'         => $this->faker->words(3, true),
            'description'   => $this->faker->paragraph,
            'price'         => $this->faker->randomFloat(2, 10, 200),
            'category_id'   => Category::factory()->create()->id,
            'image'         => $this->faker->imageUrl(),
            'rating_rate'   => $this->faker->randomFloat(1, 1, 5),
            'rating_count'  => $this->faker->numberBetween(1, 200),
        ];
    }
}
