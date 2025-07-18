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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id("ResultID");
            $table->unsignedBigInteger("userID")->nullable();
            $table->unsignedBigInteger("LicenseTypeID");
            $table->float("score");
            $table->boolean("passed");
            $table->float("Duration");
            $table->foreign("userID")->references("userID")->on("users");
            $table->foreign("LicenseTypeID")->references("LicenseTypeID")->on("license_types");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
