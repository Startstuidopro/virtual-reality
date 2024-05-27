<?php

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Question;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a student
        // $student = Student::create([
        //     'name' => 'john.doe',
        //     'password' => bcrypt('password123'), // Hash the password
        //     // Add other student fields if needed
        // ]);

        // Create 6 questions with answers
        $questions = [
            ['question' => 'What is the capital of France?', 'answer' => 'Paris'],
            ['question' => 'Who painted the Mona Lisa?', 'answer' => 'Leonardo da Vinci'],
            ['question' => 'What is the highest mountain in the world?', 'answer' => 'Mount Everest'],
            ['question' => 'What is the smallest country in the world?', 'answer' => 'Vatican City'],
            ['question' => 'What is the largest ocean in the world?', 'answer' => 'Pacific Ocean'],
            ['question' => 'What is the currency of Japan?', 'answer' => 'Japanese Yen'],
        ];

        foreach ($questions as $questionData) {
            Question::create($questionData);
        }
    }
}