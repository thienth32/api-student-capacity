<?php

namespace Database\Factories;

use App\Models\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamsFactory extends Factory
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
            'description' => $this->faker->text,
            'max_ponit' => 10,
            'external_url'=>$this->faker->sentence(15),
            'ponit' => mt_rand(1, 10),
            'round_id' => Round::all()->random()->id,
        ];
    }
}
