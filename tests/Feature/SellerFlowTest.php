<?php

use App\Models\Seller;
use App\Models\User;

test('user can become seller by clicking sell button', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('sell.entry'));

    expect($user->fresh()->seller)->not->toBeNull();
    expect($user->seller->kyc_status)->toBe('pending');
    expect($user->seller->is_active)->toBeTrue();
    $response->assertRedirect(route('seller.products.create'));
});

test('blocked seller cannot access seller pages', function () {
    $user = User::factory()->create();
    $seller = Seller::factory()->create([
        'user_id' => $user->id,
        'is_active' => false,
    ]);

    $response = $this->actingAs($user)->get(route('sell.entry'));

    $response->assertOk();
    $response->assertSee('Account Blocked');
});

test('guest is redirected to login when clicking sell', function () {
    $response = $this->get(route('sell.entry'));

    $response->assertRedirect(route('login'));
});
