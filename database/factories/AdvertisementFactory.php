<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'link' => fake()->url(),
            'source_url'=>Str::random(10).'.png',
            'duration' => fake()->randomDigit(2),
            'is_active'=>fake()->boolean(),
            'last_display'=>fake()->dateTime(),
        ];
    }
}
