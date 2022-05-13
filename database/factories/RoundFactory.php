<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Round;
use App\Models\TypeExam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Round>
 */
class RoundFactory extends Factory
{
    protected $model = Round::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'image' => $this->faker->imageUrl($width = 640, $height = 480, $category = "image"),
            'start_time' => date("Y-m-d H:i:s"),
            'end_time' => date("Y-m-d H:i:s"),
            'description' => $this->faker->sentence(15),
            'contest_id' => Contest::all()->random()->id,
            'type_exam_id' => TypeExam::all()->random()->id,
        ];
    }
}
