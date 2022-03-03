<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\enterprise;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\enterprise>
 */
class EnterpriseFactory extends Factory
{
    protected $model = enterprise::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
