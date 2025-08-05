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
            $table->string('description')->nullable();
            $table->string('slug')->nullable();

            $table->unsignedBigInteger('religion_id')->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('cascade');

            $table->unsignedBigInteger('county_id')->nullable();
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            
            $table->unsignedBigInteger('school_uniform_id')->nullable();
            $table->foreign('school_uniform_id')->references('id')->on('school_uniforms')->onDelete('cascade');

            $table->unsignedBigInteger('school_contact_id')->nullable();
            $table->foreign('school_contact_id')->references('id')->on('school_contacts')->onDelete('cascade');

            $table->unsignedBigInteger('school_address_id')->nullable();
            $table->foreign('school_address_id')->references('id')->on('school_addresses')->onDelete('cascade');

            $table->unsignedBigInteger('constituency_id')->nullable();
            $table->foreign('constituency_id')->references('id')->on('constituencies')->onDelete('cascade');

            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');

            $table->unsignedBigInteger('school_level_id')->nullable();
            $table->foreign('school_level_id')->references('id')->on('school_levels')->onDelete('cascade');

            $table->unsignedBigInteger('school_type_id')->nullable();
            $table->foreign('school_type_id')->references('id')->on('school_types')->onDelete('cascade');

            $table->unsignedBigInteger('curriculum_id')->nullable();
            $table->foreign('curriculum_id')->references('id')->on('curricula')->onDelete('cascade');

            $table->enum('ownership', ['Public', 'Private'])->nullable();
            $table->enum('gender_admission', ['Male', 'Female', 'Mixed'])->nullable();
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_active')->default(false);
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
