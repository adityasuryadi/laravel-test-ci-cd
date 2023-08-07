<?php

namespace Database\Factories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdvertisementDisplay>
 */
class AdvertisementDisplayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'advertisement_id'=>function () {
                return Advertisement::factory()->create()->id;
            },
            'merchant_id'=>fake()->randomDigit(3),
        ];
    }
}
