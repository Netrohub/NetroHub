<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'seller_id' => Seller::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(6),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 9.99, 199.99),
            'delivery_type' => fake()->randomElement(['file', 'code']),
            'status' => 'active',
            'is_featured' => fake()->boolean(20),
            'views_count' => fake()->numberBetween(0, 1000),
            'sales_count' => fake()->numberBetween(0, 100),
            'rating' => fake()->randomFloat(2, 3, 5),
            'reviews_count' => fake()->numberBetween(0, 50),
        ];
    }
}
