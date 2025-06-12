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
        Schema::create('questions', function (Blueprint $table) {
            $table->id("QuestionID");
            $table->text("QuestionName");
            $table->text("ImageDescription")->nullable();
            $table->boolean("IsCritical");
            $table->text("QuestionExplain")->nullable();
            $table->unsignedBigInteger("CategoryID");
            $table->foreign("CategoryID")->references("CategoryID")->on("question_categories");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
