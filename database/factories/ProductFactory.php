<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
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
        $category = Category::inRandomOrder()->first();
        return [
            'product_id' => $this->faker->unique()->randomNumber(5),
            'name' => $this->faker->words(3, true),
            'image' => null,
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraph(3),
            'category_id' => $category->category_id,

        ];
    }

    public function withSeller(): static
    {
        return $this->state(function (array $attributes) {
            $sellerFunctionId = 2;

            $seller = User::where('function_id', $sellerFunctionId)->inRandomOrder()->first()
                        ?? User::factory()->state(['function_id' => $sellerFunctionId])->create();

            return [
                'seller_id' => $seller->user_id,
            ];
        });
    }
}
