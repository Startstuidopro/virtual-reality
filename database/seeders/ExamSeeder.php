<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\User;
class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create exams for each doctor
        $doctors = User::where('role', 'doctor')->get();

        foreach ($doctors as $doctor) {
            Exam::factory()->count(2)->create([
                'doctor_id' => $doctor->id,
            ]);
        }
    }
}