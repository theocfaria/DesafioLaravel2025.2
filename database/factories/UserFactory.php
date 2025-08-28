<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'cep' => $this->faker->numerify('#####-###'),
            'number' => $this->faker->buildingNumber(),
            'street' => $this->faker->streetName(),
            'district' => $this->faker->citySuffix(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'extra_info' => $this->faker->optional()->secondaryAddress(),
            'phone_number' => $this->faker->numerify('(##) #####-####'),
            'birth' => $this->faker->phoneNumber(),
            'cpf' => $this->faker->numerify("###.###.###-##"),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'image' => null,
            'function_id' => Role::where('name', 'Usuário')->first()->function_id(),
            'father_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
