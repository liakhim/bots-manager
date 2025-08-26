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
        Schema::create('b2_words_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('b2_word_id');
            $table->string('body')->nullable();
            $table->text('body_translation')->nullable();
            $table->string('example')->nullable();
            $table->text('example_translation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2_words_definitions');
    }
};
