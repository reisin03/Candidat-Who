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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('id_document')->nullable()->after('profile_picture');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('id_document');
            $table->text('verification_notes')->nullable()->after('verification_status');
            $table->timestamp('verified_at')->nullable()->after('verification_notes');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->boolean('is_super_admin')->default(false)->after('verified_by');
            
            // Foreign key to admins table for who verified this admin (super admin verification)
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'id_document',
                'verification_status',
                'verification_notes',
                'verified_at',
                'verified_by',
                'is_super_admin'
            ]);
        });
    }
};
