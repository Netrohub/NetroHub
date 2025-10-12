<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'display_name' => fake()->company(),
            'bio' => fake()->paragraph(),
            'kyc_status' => 'pending',
            'is_active' => true,
            'rating' => fake()->randomFloat(2, 3, 5),
            'total_sales' => fake()->numberBetween(0, 100),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'kyc_status' => 'approved',
        ]);
    }

    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
