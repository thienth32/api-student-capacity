<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillsFactory extends Factory
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
            'short_name' => strtoupper($this->unique()->text(5)),
            'image_url' => $this->faker->imageUrl($width = 640, $height = 480, $category = "image_url"),
            'description' => $this->faker->text,

        ];
    }
}
