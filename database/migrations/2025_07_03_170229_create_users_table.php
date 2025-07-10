<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth')->nullable();
            $table->foreignId('county_id')->constrained()->cascadeOnDelete();
            $table->foreignId('constituency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->string('school_name');
            $table->foreignId('curriculum_id')->constrained()->cascadeOnDelete();
            $table->string('profile_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
