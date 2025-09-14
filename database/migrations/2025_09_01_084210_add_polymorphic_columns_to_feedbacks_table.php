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
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->nullableMorphs('feedbackable'); // Adds feedbackable_type and feedbackable_id
            $table->foreignId('poll_option_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropMorphs('feedbackable');
            $table->dropForeign(['poll_option_id']);
            $table->dropColumn('poll_option_id');
        });
    }
};
