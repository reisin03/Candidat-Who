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
        Schema::table('running_officials', function (Blueprint $table) {
            if (!Schema::hasColumn('running_officials', 'middle_initial')) {
                $table->string('middle_initial')->nullable()->after('fname');
            }
            if (!Schema::hasColumn('running_officials', 'email')) {
                $table->string('email')->nullable()->after('credentials');
            }
            if (!Schema::hasColumn('running_officials', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('running_officials', function (Blueprint $table) {
            if (Schema::hasColumn('running_officials', 'middle_initial')) {
                $table->dropColumn('middle_initial');
            }
            if (Schema::hasColumn('running_officials', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('running_officials', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
