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
            $table->string('position')->after('lname');
            $table->string('address')->nullable()->after('age');
            $table->date('birthdate')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('running_sks', function (Blueprint $table) {
            $table->dropColumn(['position', 'address', 'birthdate']);
        });
    }
};
