<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contest;
use App\Models\Major;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contest>
 */
class ContestFactory extends Factory
{
    protected $model = Contest::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'img' => '629ec972b4ef3-1654573426.jpg',
            'date_start' => date("Y-m-d H:i:s"),
            'register_deadline' => date("Y-m-d H:i:s"),
            'start_register_time' => date("Y-m-d H:i:s"),
            'end_register_time' => date("Y-m-d H:i:s"),
            'max_user' => 10,
            'major_id' => Major::all()->random()->id,
            'status' => true,
            'description' => $this->faker->sentence(15),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'type' => 1
        ];
    }
}
