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
        Schema::create('exam_set_license_type', function (Blueprint $table) {
            $table->id("ExamsetLicenseTypeID");
            $table->unsignedBigInteger("ExamsetID");
            $table->unsignedBigInteger("LicenseTypeID");
            $table->foreign("ExamSetID")->references("ExamSetID")->on("exam_sets");
            $table->foreign("LicenseTypeID")->references("LicenseTypeID")->on("license_types");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_set_license_type');
    }
};
