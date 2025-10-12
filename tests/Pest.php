<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
)->in('Feature');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function actingAs($user, $guard = null)
{
    return test()->actingAs($user, $guard);
}
