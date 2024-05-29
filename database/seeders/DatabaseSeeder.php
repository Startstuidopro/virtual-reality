<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            QuestionCategorySeeder::class, // Seed categories before questions
            ExamSeeder::class,
            QuestionSeeder::class, 
            // ... call other seeders in the correct order ...
        ]);
    }
}