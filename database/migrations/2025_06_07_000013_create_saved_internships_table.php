<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the saved_internships table.
     * Supports FR15 (Saved Opportunities).
     */
    public function up(): void
    {
        Schema::create('saved_internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('student_profiles')
                  ->cascadeOnDelete();
            $table->foreignId('internship_id')
                  ->constrained('internships')
                  ->cascadeOnDelete();
            $table->timestamps();

            // FR15.1: A student can save an internship only once
            $table->unique(['student_id', 'internship_id'], 'unique_saved_internship');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_internships');
    }
};
