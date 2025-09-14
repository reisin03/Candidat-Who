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
        // Feedback table
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // optional if user is logged in
            $table->string('subject')->nullable();
            $table->text('message');
            $table->tinyInteger('rating')->nullable(); // optional rating (1-5)
            $table->timestamps();
        });

        // Polls table
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('question');        // The poll question
            $table->timestamps();
        });

        // Poll options table
        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained()->onDelete('cascade'); // Link to poll
            $table->string('option_text');      // The answer option
            $table->unsignedInteger('votes')->default(0); // Number of votes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
