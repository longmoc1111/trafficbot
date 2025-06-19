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
        Schema::create('license_type_question_category', function (Blueprint $table) {
            $table->id("LicenseQuestionTypeID");
            $table->unsignedBigInteger("LicenseTypeID");
            $table->unsignedBigInteger("CategoryID");
            $table->foreign("LicenseTypeID")->references("LicenseTypeID")->on("license_types");
            $table->foreign("CategoryID")->references("CategoryID")->on("question_categories");
            $table->integer("Quantity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_type_question_category');
    }
};
