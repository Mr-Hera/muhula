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
        Schema::create('school_user', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

            // New: Contact position (foreign key to positions table)
            $table->unsignedBigInteger('contact_position_id')->nullable();
            $table->foreign('contact_position_id')->references('id')->on('contact_positions')->onDelete('set null');
            
            // New: Proof of association file (PDF/Image path)
            $table->string('proof_of_association')->nullable();
            
            // Optional: store claim status or timestamp
            $table->enum('claim_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('claimed_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'school_id']); // Prevent duplicate claims
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_user');
    }
};
