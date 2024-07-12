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
        Schema::create('channel_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('channel_id')->nullable();
            $table->string('description')->nullable();
            $table->string('icon_color')->nullable();
            $table->string('image')->nullable();
            $table->integer('message_thread_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_topics');
    }
};
