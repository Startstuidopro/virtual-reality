<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_degrees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attempt_id');
            $table->decimal('score', 5, 2); // Adjust precision and scale as needed
            $table->timestamps();

            $table->foreign('attempt_id')->references('id')->on('exam_attempts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_degrees');
    }
}
