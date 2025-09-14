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
        Schema::table('officials', function (Blueprint $table) {
            if (!Schema::hasColumn('officials', 'fname')) {
                $table->string('fname')->nullable()->after('id');
            }
            if (!Schema::hasColumn('officials', 'middle_initial')) {
                $table->string('middle_initial')->nullable()->after('fname');
            }
            if (!Schema::hasColumn('officials', 'lname')) {
                $table->string('lname')->nullable()->after('middle_initial');
            }
        });

        // Migrate existing name data to fname/lname (only if name column exists)
        if (Schema::hasColumn('officials', 'name')) {
            DB::statement("
                UPDATE officials
                SET fname = SUBSTRING_INDEX(name, ' ', 1),
                    lname = SUBSTRING_INDEX(name, ' ', -1)
                WHERE name IS NOT NULL AND fname IS NULL
            ");
        }

        Schema::table('officials', function (Blueprint $table) {
            if (Schema::hasColumn('officials', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            if (!Schema::hasColumn('officials', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
        });

        // Restore name from fname/lname (only if name column exists)
        if (Schema::hasColumn('officials', 'name')) {
            DB::statement("
                UPDATE officials
                SET name = CONCAT_WS(' ', fname, lname)
                WHERE fname IS NOT NULL OR lname IS NOT NULL
            ");
        }

        Schema::table('officials', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('officials', 'fname')) {
                $columnsToDrop[] = 'fname';
            }
            if (Schema::hasColumn('officials', 'middle_initial')) {
                $columnsToDrop[] = 'middle_initial';
            }
            if (Schema::hasColumn('officials', 'lname')) {
                $columnsToDrop[] = 'lname';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
