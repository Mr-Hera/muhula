<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('search_term');
            $table->foreignId('level_id')->nullable()->constrained('school_levels')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('school_types')->nullOnDelete();
            $table->foreignId('county_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('curriculum_id')->nullable()->constrained('curricula')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_logs');
    }
}
