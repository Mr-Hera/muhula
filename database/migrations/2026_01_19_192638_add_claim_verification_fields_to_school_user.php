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
        Schema::table('school_user', function (Blueprint $table) {
            $table->json('proof_of_association')->nullable()->change();
            $table->string('claim_status')->default('pending')->change();
            $table->string('email_domain')->nullable();
            $table->string('verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->json('auto_verification_result')->nullable();
            $table->boolean('auto_approved')->default(false);
            $table->text('rejection_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_user', function (Blueprint $table) {
            $table->string('proof_of_association')->nullable()->change();
            $table->enum('claim_status', ['pending', 'approved', 'rejected'])->default('pending')->change();

            $table->dropColumn([
                'email_domain',
                'verification_token',
                'email_verified_at',
                'auto_verification_result',
                'auto_approved',
                'rejection_reason',
            ]);
        });
    }
};
