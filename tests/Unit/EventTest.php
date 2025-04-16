<?php

use App\Models\Event;
use App\Models\User;

test('event has title', function () {
    $event = Event::factory()->create(['title' => 'Test Event']);
    expect($event->title)->toBe('Test Event');
});

test('event description can be null', function () {
    $event = Event::factory()->create(['description' => null]);
    expect($event->description)->toBeNull();
});

test('event has start and end times', function () {
    $start = now();
    $end = now()->addHours(2);
    $event = Event::factory()->create(['starts_at' => $start, 'ends_at' => $end]);
    
    expect($event->starts_at)->toEqual($start);
    expect($event->ends_at)->toEqual($end);
});

test('event has location', function () {
    $event = Event::factory()->create(['location' => 'Conference Room']);
    expect($event->location)->toBe('Conference Room');
});

test('event price can be null', function () {
    $event = Event::factory()->create(['price' => null]);
    expect($event->price)->toBeNull();
});

test('event has numeric price', function () {
    $event = Event::factory()->create(['price' => 99.99]);
    expect($event->price)->toBe(99.99);
});

test('event capacity can be null', function () {
    $event = Event::factory()->create(['capacity' => null]);
    expect($event->capacity)->toBeNull();
});

test('event has integer capacity', function () {
    $event = Event::factory()->create(['capacity' => 100]);
    expect($event->capacity)->toBe(100);
});

test('event image can be null', function () {
    $event = Event::factory()->create(['image' => null]);
    expect($event->image)->toBeNull();
});

test('event has image path', function () {
    $event = Event::factory()->create(['image' => 'events/image.jpg']);
    expect($event->image)->toBe('events/image.jpg');
});

test('event has many users', function () {
    $event = Event::factory()->hasUsers(3)->create();
    expect($event->users)->toHaveCount(3);
    expect($event->users->first())->toBeInstanceOf(User::class);
});
