<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the student_profiles table.
     * Supports FR3 (Student Profile Management).
     */
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();

            // Personal Information
            $table->string('full_name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();

            // Academic Information
            $table->string('university');
            $table->string('program'); // Degree programme
            $table->year('graduation_year');

            // Professional Information
            $table->json('skills')->nullable(); // Stored as JSON array

            // Uploaded Files (stored relative to storage disk)
            $table->string('cv_path', 500)->nullable();
            $table->string('cover_letter_path', 500)->nullable();
            $table->string('profile_photo_path', 500)->nullable();

            // Profile completion cache (0-100)
            $table->unsignedTinyInteger('completion_percentage')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
