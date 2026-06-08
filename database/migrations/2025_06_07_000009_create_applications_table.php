<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the applications table.
     * Supports FR9 (Internship Application) and FR10 (Application Tracking).
     *
     * Status lifecycle:
     *   submitted -> under_review -> shortlisted -> interview_scheduled -> accepted / rejected
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('internship_id')
                  ->constrained('internships')
                  ->cascadeOnDelete();
            $table->foreignId('student_id')
                  ->constrained('student_profiles')
                  ->cascadeOnDelete();

            // Submitted Documents
            $table->string('cv_path', 500);
            $table->string('cover_letter_path', 500)->nullable();

            // Status
            $table->enum('status', [
                'submitted',
                'under_review',
                'shortlisted',
                'interview_scheduled',
                'accepted',
                'rejected',
            ])->default('submitted');

            // Internal company notes (not visible to student)
            $table->text('company_notes')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // FR9.3: One application per student per internship
            $table->unique(['internship_id', 'student_id'], 'unique_application');

            $table->index(['student_id', 'status']);
            $table->index(['internship_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
