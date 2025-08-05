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
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

            $table->unsignedBigInteger('school_type_id')->nullable();
            $table->foreign('school_type_id')->references('id')->on('school_types')->onDelete('cascade');

            $table->unsignedBigInteger('county_id')->nullable();
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');

            $table->unsignedBigInteger('school_address_id')->nullable();
            $table->foreign('school_address_id')->references('id')->on('school_addresses')->onDelete('cascade');

            $table->unsignedBigInteger('school_image_id')->nullable();
            $table->foreign('school_image_id')->references('id')->on('school_images')->onDelete('cascade');
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
