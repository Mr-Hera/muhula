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
        Schema::create('school_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('county_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_address_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_image_id')->constrained()->cascadeOnDelete();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_branches');
    }
};
