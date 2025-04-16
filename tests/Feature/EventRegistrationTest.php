<?php

use App\Exceptions\{DuplicateRegistrationException, EventEndedException, EventFullException};
use App\Models\{Event, User};
use App\Repositories\Interfaces\EventRegistrationRepositoryInterface;
use App\Services\EventRegistrationService;
use Carbon\Carbon;

beforeEach(function () {
    $this->repository = mock(EventRegistrationRepositoryInterface::class);
    $this->instance(EventRegistrationRepositoryInterface::class, $this->repository);
});

it('allows user to register for an event', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $this->actingAs($user);

    $this->repository
        ->shouldReceive('findWithUsersCount')
        ->once()
        ->andReturn((object)[
            'id' => $event->id,
            'ends_at' => Carbon::now()->addDay(),
            'capacity' => null,
            'users_count' => 0,
        ]);

    $this->repository
        ->shouldReceive('isUserRegistered')
        ->once()
        ->with($event->id, $user->id)
        ->andReturn(false);

    $this->repository
        ->shouldReceive('registerUser')
        ->once()
        ->with($event->id, $user->id);

    $this->post(route('events.register', $event))
        ->assertRedirect()
        ->assertSessionHas('success', __('You have registered for the event.'));
});

it('throws EventEndedException when event already ended', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $this->actingAs($user);

    $this->repository
        ->shouldReceive('findWithUsersCount')
        ->once()
        ->andReturn((object)[
            'id' => $event->id,
            'ends_at' => Carbon::now()->subDay(),
            'capacity' => null,
            'users_count' => 0,
        ]);

    $service = app(EventRegistrationService::class);

    $service->register($event, $user);
})->throws(EventEndedException::class);

it('throws EventFullException when event is full', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $this->actingAs($user);

    $this->repository
        ->shouldReceive('findWithUsersCount')
        ->once()
        ->andReturn((object)[
            'id' => $event->id,
            'ends_at' => Carbon::now()->addDay(),
            'capacity' => 50,
            'users_count' => 50,
        ]);

    $service = app(EventRegistrationService::class);

    $service->register($event, $user);
})->throws(EventFullException::class);

it('throws DuplicateRegistrationException if user already registered', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $this->actingAs($user);

    $this->repository
        ->shouldReceive('findWithUsersCount')
        ->once()
        ->andReturn((object)[
            'id' => $event->id,
            'ends_at' => Carbon::now()->addDay(),
            'capacity' => null,
            'users_count' => 10,
        ]);

    $this->repository
        ->shouldReceive('isUserRegistered')
        ->once()
        ->with($event->id, $user->id)
        ->andReturn(true);

    $service = app(EventRegistrationService::class);

    $service->register($event, $user);
})->throws(DuplicateRegistrationException::class);

it('allows user to unregister from an event', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $this->actingAs($user);

    $this->repository
        ->shouldReceive('unregisterUser')
        ->once()
        ->with($event->id, $user->id);

    $this->post(route('events.unregister', $event))
        ->assertRedirect()
        ->assertSessionHas('success', __('You have unregistered from the event.'));
});
