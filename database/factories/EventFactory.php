<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'starts_at' => $startDate = $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'ends_at' => $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s').' +3 days'),
            'location' => $this->faker->address(),
            'price' => $this->faker->randomElement([null, $this->faker->randomFloat(2, 10, 500)]),
            'capacity' => $this->faker->randomElement([null, $this->faker->numberBetween(10, 500)]),
            'image' => $this->faker->randomElement([null, $this->faker->imageUrl()]),
        ];
    }
}
