<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_exam_sets', function (Blueprint $table) {
            $table->id("QuestionExamsetID");
            $table->unsignedBigInteger("QuestionID");
            $table->unsignedBigInteger("ExamSetID");
            $table->foreign("QuestionID")->references("QuestionID")->on("questions");
            $table->foreign("ExamSetID")->references("ExamSetID")->on("exam_sets");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_exam_sets');
    }
};
