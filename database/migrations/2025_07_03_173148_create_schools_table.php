<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('school_level_id')->constrained('school_levels')->cascadeOnDelete();
            $table->foreignId('school_type_id')->constrained('school_types')->cascadeOnDelete();
            $table->foreignId('curriculum_id')->constrained('curricula')->cascadeOnDelete();
            $table->enum('ownership', ['Public', 'Private']);
            $table->enum('gender_admission', ['Male', 'Female', 'Mixed']);
            $table->foreignId('county_id')->constrained()->cascadeOnDelete();
            $table->foreignId('constituency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->text('address');
            $table->string('logo')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('website_url')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
