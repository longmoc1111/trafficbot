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
        Schema::create('signage_types', function (Blueprint $table) {
            $table->id("SignageTypeID");
            $table->string("SignagesTypeName");
            $table->text("SignagesTypeDescription");      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signage_types');
    }
};
