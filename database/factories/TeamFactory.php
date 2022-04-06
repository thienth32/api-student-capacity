<?php

namespace Database\Factories;

use App\Models\Contest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'contest_id' => Contest::all()->random()->id,
            'image' => 'https://i.pinimg.com/originals/6a/54/2a/6a542ae20b05d5129568fd49e03adb16.jpg',
        ];
    }
}
