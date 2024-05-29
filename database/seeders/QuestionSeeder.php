<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Exam;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create questions for each exam
        $exams = Exam::all();

        foreach ($exams as $exam) {
            Question::factory()->count(5)->create([
                'exam_id' => $exam->id,
            ]);
        }
    }
}