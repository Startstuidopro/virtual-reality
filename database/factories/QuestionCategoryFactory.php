<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuestionCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionCategory>
 */
class QuestionCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence, 
        ];
    }
}