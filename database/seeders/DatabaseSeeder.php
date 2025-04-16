<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@eventhub.com',
            'password' => bcrypt('password123'),
        ]);

        User::factory(10)->create();
        Event::factory(20)->create();

        $events = Event::all();
        User::all()->each(function ($user) use ($events) {
            $user->events()->attach(
                $events->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
