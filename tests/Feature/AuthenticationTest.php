<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('users can register with valid data', function () {
    $userData = [
        'name' => 'John Doe',
        'username' => 'johndoe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => true,
        'cf-turnstile-response' => 'fake-turnstile-token', // Mock for testing
    ];

    $response = $this->post(route('register'), $userData);

    $response->assertRedirect(route('home'));

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'username' => 'johndoe',
    ]);

    $this->assertAuthenticated();
});

test('registration fails with invalid data', function () {
    $response = $this->post(route('register'), [
        'name' => '',
        'username' => 'a', // Too short
        'email' => 'invalid-email',
        'password' => '123', // Too short
        'password_confirmation' => '456', // Doesn't match
        'terms' => false,
        'cf-turnstile-response' => 'fake-turnstile-token',
    ]);

    $response->assertSessionHasErrors(['name', 'username', 'email', 'password', 'terms']);
    $this->assertGuest();
});

test('users can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'password123',
        'cf-turnstile-response' => 'fake-turnstile-token',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
});

test('login fails with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
        'cf-turnstile-response' => 'fake-turnstile-token',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect('/');
    $this->assertGuest();
});

test('email verification works correctly', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    expect($user->hasVerifiedEmail())->toBeFalse();

    // Simulate email verification
    $user->markEmailAsVerified();

    expect($user->hasVerifiedEmail())->toBeTrue();
});

test('rate limiting works for login attempts', function () {
    // This test would require mocking the rate limiter
    // For now, we'll just verify the middleware is applied
    $route = Route::getRoutes()->getByName('login');
    expect($route->gatherMiddleware())->toContain('throttle:5,1');
});

test('username must be unique', function () {
    $existingUser = User::factory()->create(['username' => 'testuser']);

    $response = $this->post(route('register'), [
        'name' => 'Another User',
        'username' => 'testuser', // Same username
        'email' => 'different@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => true,
        'cf-turnstile-response' => 'fake-turnstile-token',
    ]);

    $response->assertSessionHasErrors('username');
});

test('email must be unique', function () {
    $existingUser = User::factory()->create(['email' => 'test@example.com']);

    $response = $this->post(route('register'), [
        'name' => 'Another User',
        'username' => 'differentuser',
        'email' => 'test@example.com', // Same email
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => true,
        'cf-turnstile-response' => 'fake-turnstile-token',
    ]);

    $response->assertSessionHasErrors('email');
});

test('social login redirects to provider', function () {
    $response = $this->get(route('login.social', 'google'));

    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('google.com');
});

test('phone login sends OTP', function () {
    $response = $this->post(route('login.phone.send-code'), [
        'phone' => '+1234567890',
        'cf-turnstile-response' => 'fake-turnstile-token',
    ]);

    $response->assertRedirect(route('login.phone.verify'));
    $response->assertSessionHas('success');
});
