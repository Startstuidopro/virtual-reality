<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionCategory;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Math', 'description' => 'Mathematics questions'],
            ['name' => 'Science', 'description' => 'Science-related questions'],
            ['name' => 'History', 'description' => 'History questions'],
            // ... add more categories ...
        ];

        foreach ($categories as $category) {
            QuestionCategory::create($category);
        }
    }
}