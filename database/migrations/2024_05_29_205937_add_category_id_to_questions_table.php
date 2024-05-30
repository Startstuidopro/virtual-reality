<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(); // Add the category_id column
            $table->foreign('category_id')->references('id')->on('question_categories');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // Drop the foreign key constraint
            $table->dropColumn('category_id'); // Drop the column
        });
    }
}