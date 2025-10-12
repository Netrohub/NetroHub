<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

test('seller can create product', function () {
    $user = User::factory()->create();
    $seller = Seller::factory()->create(['user_id' => $user->id, 'is_active' => true]);
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post(route('seller.products.store'), [
        'title' => 'Test Product',
        'description' => 'Test description',
        'category_id' => $category->id,
        'price' => 29.99,
        'delivery_type' => 'file',
    ]);

    $this->assertDatabaseHas('products', [
        'title' => 'Test Product',
        'seller_id' => $seller->id,
    ]);
});

test('products are visible on homepage', function () {
    Product::factory()->count(3)->create(['status' => 'active']);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('NetroHub');
});

test('product detail page increments views', function () {
    $product = Product::factory()->create(['status' => 'active', 'views_count' => 0]);

    $this->get(route('products.show', $product->slug));

    expect($product->fresh()->views_count)->toBe(1);
});
