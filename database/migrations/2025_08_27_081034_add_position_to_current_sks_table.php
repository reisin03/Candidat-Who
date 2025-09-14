<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('current_sks', function (Blueprint $table) {
            $table->string('position')->after('lname'); // add position column after last name
        });
    }

    public function down()
    {
        Schema::table('current_sks', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
