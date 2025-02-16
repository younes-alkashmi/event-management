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
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->text(200),
            'category_id' => \App\Models\Category::factory(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'max_tickets' => $this->faker->numberBetween(1, 100),
        ];
    }
}
