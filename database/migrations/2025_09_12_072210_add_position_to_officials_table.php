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
        Schema::table('officials', function (Blueprint $table) {
            if (!Schema::hasColumn('officials', 'position')) {
                $table->string('position')->nullable()->after('lname');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            if (Schema::hasColumn('officials', 'position')) {
                $table->dropColumn('position');
            }
        });
    }
};
