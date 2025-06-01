<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(10),
            'desc' => fake()->paragraph(12),
            'email' => fake()->email(),
            'link' => fake()->url(),
            'tags' => fake()->randomElement([
                'dev,game',
                'game',
                'biz,tech',
                'tech,game,biz'
            ]),
            'status' => 1,
        ];
    }
}
