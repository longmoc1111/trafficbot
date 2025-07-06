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
        Schema::create('chat_bots', function (Blueprint $table) {
            $table->id("ChatbotID");
            $table->string("DocumentName");
            $table->text("DocumentDesciption")->nullable();
            $table->string("File")->nullable();
            $table->text("LinkURL")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbots');
    }
};
