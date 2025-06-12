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
        Schema::create('answers', function (Blueprint $table) {
            $table->id("AnswerID");
            $table->string('AnswerLabel', 1)->nullable();
            $table->text("AnswerName");
            $table->boolean("IsCorrect");
            $table->unsignedBigInteger("QuestionID");
            $table->foreign("QuestionID")->references("QuestionID")->on("questions");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
