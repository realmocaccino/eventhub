<?php

use Laravel\Dusk\Browser;
use App\Models\{User, Event};

test('login and register to an event', function () {
    $user = User::factory()->create([
        'email' => fake()->unique()->safeEmail,
        'password' => bcrypt('password123'),
    ]);
    $event = Event::factory()->create([
        'title' => 'Test Event',
    ]);

    $this->browse(function (Browser $browser) use ($user, $event) {
        $browser->visit(route('login'))
            ->waitFor('[type=email]', 2)
            ->type('[type=email]', 'testuser@example.com')
            ->type('[type=password]', 'password123')
            ->press('Sign In');

        $browser->visit(route('events.show', $event))
            ->press('Register Now')
            ->assertSee('You have registered for the event.');
    });
});