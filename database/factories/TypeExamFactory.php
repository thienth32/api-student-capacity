<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TypeExam;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeExam>
 */
class TypeExamFactory extends Factory
{
    protected $model = TypeExam::class;
    /**
     *
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description'=>$this->faker->text
        ];
    }
}
