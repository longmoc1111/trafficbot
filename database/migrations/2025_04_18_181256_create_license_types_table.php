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
        Schema::create('license_types', function (Blueprint $table) {
            $table->id("LicenseTypeID");
            $table->string("LicenseTypeName");
            $table->text("LicenseTypeDescription")->nullable();
            $table->integer("LicenseTypeDuration");
            $table->integer("LicenseTypeQuantity");
            $table->integer("LicenseTypePassCount");
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_types');
    }
};
