<?php

use App\Models\Event;
use App\Models\User;

test('user has name', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    expect($user->name)->toBe('John Doe');
});

test('user has email', function () {
    $user = User::factory()->create(['email' => 'john@example.com']);
    expect($user->email)->toBe('john@example.com');
});

test('user email is unique', function () {
    User::factory()->create(['email' => 'john@example.com']);
    expect(fn() => User::factory()->create(['email' => 'john@example.com']))->toThrow(\Illuminate\Database\QueryException::class);
});

test('user email verified at can be null', function () {
    $user = User::factory()->create(['email_verified_at' => null]);
    expect($user->email_verified_at)->toBeNull();
});

test('user has password', function () {
    $user = User::factory()->create(['password' => 'secret']);
    expect($user->password)->toBeString();
});

test('user is not admin by default', function () {
    $user = User::factory()->create();
    expect($user->is_admin)->toBeFalse();
});

test('user can be admin', function () {
    $user = User::factory()->admin()->create();
    expect($user->is_admin)->toBeTrue();
});

test('user has many events', function () {
    $user = User::factory()->hasEvents(2)->create();
    expect($user->events)->toHaveCount(2);
    expect($user->events->first())->toBeInstanceOf(Event::class);
});