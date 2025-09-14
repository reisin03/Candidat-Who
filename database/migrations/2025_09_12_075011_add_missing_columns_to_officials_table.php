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
            if (!Schema::hasColumn('officials', 'phone')) {
                $table->string('phone')->nullable()->after('position');
            }
            if (!Schema::hasColumn('officials', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('officials', 'description')) {
                $table->text('description')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('officials', 'phone')) {
                $columnsToDrop[] = 'phone';
            }
            if (Schema::hasColumn('officials', 'email')) {
                $columnsToDrop[] = 'email';
            }
            if (Schema::hasColumn('officials', 'description')) {
                $columnsToDrop[] = 'description';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
