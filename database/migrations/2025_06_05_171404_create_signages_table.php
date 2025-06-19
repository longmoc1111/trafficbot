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
        Schema::create('signages', function (Blueprint $table) {
            $table->id("SignageID");
            $table->text("SignageName");
            $table->text("SignagesExplanation");
            $table->unsignedBigInteger("SignageTypeID");
            $table->foreign("SignageTypeID")->references("SignageTypeID")->on("signage_types");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signages');
    }
};
