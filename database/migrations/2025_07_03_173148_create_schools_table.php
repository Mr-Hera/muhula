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
            $table->integer('year_of_establishment')->nullable();
            $table->string('name');
            $table->string('description');
            $table->string('slug');
            $table->string('religion')->nullable();
            $table->foreignId('county_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_uniform_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_address_id')->constrained('school_addresses')->cascadeOnDelete();
            $table->foreignId('constituency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_level_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curriculum_id')->constrained('curricula')->cascadeOnDelete();
            $table->foreignId('school_operation_hour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('extended_school_service_id')->constrained()->cascadeOnDelete();
            $table->enum('ownership', ['Public', 'Private']);
            $table->enum('gender_admission', ['Male', 'Female', 'Mixed']);
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
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
