<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Question;
use App\Models\Exam;
use App\Models\QuestionCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $answerTypes = ['single_choice', 'multiple_choice', 'open_ended'];
        $answerType = $this->faker->randomElement($answerTypes);

        $options = [];
        if ($answerType === 'single_choice' || $answerType === 'multiple_choice') {
            // Generate options as an array and convert to an array
            $options = explode(' ', $this->faker->words(3, true));
        }

        $correctAnswer = '';
        if ($answerType === 'single_choice') {
            $correctAnswer = $this->faker->randomElement($options); // Randomly choose one option
        } else if ($answerType === 'multiple_choice') {
            // Use the count() function on the array
            $correctAnswer = $this->faker->randomElements($options, rand(1, count($options)));
        }

        return [
            'exam_id' => $this->faker->randomElement(Exam::pluck('id')->toArray()),
            'question_text' => $this->faker->sentence,
            'answer_type' => $answerType,
            'options' => $options ? json_encode($options) : null, // Store options as JSON
            'correct_answer' => json_encode($correctAnswer), // Store correct answer as JSON
            'category_id' => $this->faker->randomElement(QuestionCategory::pluck('id')->toArray()),
        ];
    }
}