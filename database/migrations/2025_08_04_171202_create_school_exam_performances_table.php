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
        Schema::create('school_exam_performances', function (Blueprint $table) {
            $table->id();
    
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            $table->string('exam'); // e.g., "KCSE 2024"
            $table->integer('ranking_position')->nullable(); // e.g., 5
            $table->string('region')->nullable(); // e.g., "Nairobi"
            $table->decimal('mean_score_points', 5, 2)->nullable(); // e.g., 8.53
            $table->string('mean_grade')->nullable(); // e.g., "B+"
            $table->integer('number_of_candidates')->nullable(); // e.g., 145

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_exam_performances');
    }
};
