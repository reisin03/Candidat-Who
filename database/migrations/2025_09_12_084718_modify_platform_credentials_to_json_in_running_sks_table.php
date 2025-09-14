<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert existing text data to JSON format
        DB::statement('UPDATE running_sks SET platform = JSON_ARRAY(platform) WHERE platform IS NOT NULL AND platform != ""');
        DB::statement('UPDATE running_sks SET credentials = JSON_ARRAY(credentials) WHERE credentials IS NOT NULL AND credentials != ""');

        Schema::table('running_sks', function (Blueprint $table) {
            $table->json('platform')->nullable()->change();
            $table->json('credentials')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('running_sks', function (Blueprint $table) {
            $table->text('platform')->nullable()->change();
            $table->text('credentials')->nullable()->change();
        });
    }
};
