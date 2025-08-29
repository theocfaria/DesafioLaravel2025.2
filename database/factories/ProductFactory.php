<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seller = User::inRandomOrder()->whereHas('role', function ($query) {
            $query->where('name', 'Usuário');
        })->first();

        $category = Category::inRandomOrder()->first();
        $categoryId = $category->category_id;

        return [
            'product_id' => fake()->unique()->randomNumber(5, true), // Ex: um número aleatório de 5 dígitos

            'name' => fake()->word(),
            'image' => null,
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->numberBetween(1, 100),
            'description' => fake()->sentence(8),
            'seller_id' => $seller->id_user,
            'category_id' => $categoryId,
        ];
    }
}