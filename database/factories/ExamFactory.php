<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exam;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3), 
            'description' => $this->faker->paragraph,
            'doctor_id' =>  $this->faker->randomElement(User::where('role', 'doctor')->pluck('id')->toArray()),
        ];
    }
}