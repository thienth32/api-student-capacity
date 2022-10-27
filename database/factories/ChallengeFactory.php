<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Bài test ' . $this->faker->name,
            'rank_point' => '{"top1": "10", "top2": "9", "top3": "8", "leave": "5"}',
            'content' => $this->faker->sentence(20)
        ];
    }
}