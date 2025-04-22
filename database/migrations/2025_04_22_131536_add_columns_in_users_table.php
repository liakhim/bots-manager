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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tg_username')->after('email')->nullable();
            $table->boolean('is_bot')->after('tg_username')->nullable();
            $table->string('language_code')->after('is_bot')->nullable();
            $table->boolean('is_premium')->after('language_code')->nullable();
            $table->string('chat_id')->after('is_premium')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tg_username');
            $table->dropColumn('is_bot');
            $table->dropColumn('language_code');
            $table->dropColumn('is_premium');
            $table->dropColumn('chat_id');
        });
    }
};
