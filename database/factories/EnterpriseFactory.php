<?php

namespace Database\Factories;

use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\enterprise>
 */
class EnterpriseFactory extends Factory
{
    protected $model = Enterprise::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'logo'=>$this->faker->imageUrl($width = 640, $height = 480, $category = "logo"),
            'description'=>$this->faker->text
        ];
    }
}
