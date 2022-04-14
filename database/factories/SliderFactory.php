<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start_time' => date("Y-m-d H:i:s"),
            'end_time' => date("Y-m-d H:i:s"),
            'major_id' => Major::all()->random()->id,
            'round_id' => Round::all()->random()->id,
            'image_url' => $this->faker->imageUrl($width = 640, $height = 480, $category = "image_url"),
            'link_to'=>$this->faker->sentence(15)
        ];
    }
}
