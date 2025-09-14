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
        Schema::table('running_sks', function (Blueprint $table) {
            $table->string('middle_initial')->nullable()->after('fname');
            $table->string('email')->nullable()->after('credentials');
            $table->string('phone')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('running_sks', function (Blueprint $table) {
            $table->dropColumn(['middle_initial', 'email', 'phone']);
        });
    }
};
