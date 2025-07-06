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
        Schema::table('chat_bots', function (Blueprint $table) {
            $table->mediumText("Content")->after("File")->nullable();
            $table->unsignedBigInteger("CategoryID")->after("Content");
            $table->foreign("CategoryID")->references("CategoryID")->on("chat_categories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chatbots', function (Blueprint $table) {
            //
        });
    }
};
