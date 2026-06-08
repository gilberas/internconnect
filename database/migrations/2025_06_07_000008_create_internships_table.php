<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the internships table.
     * Supports FR6 (Internship Management) and FR7 (Approval Workflow).
     *
     * Status lifecycle:
     *   pending -> approved -> closed
     *   pending -> rejected -> pending (resubmit)
     */
    public function up(): void
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('company_id')
                  ->constrained('company_profiles')
                  ->cascadeOnDelete();
            $table->foreignId('category_id')
                  ->constrained('internship_categories')
                  ->restrictOnDelete();

            // Core Details
            $table->string('title');
            $table->longText('description');
            $table->text('requirements');
            $table->text('responsibilities');
            $table->json('skills_required')->nullable();    // Array of skill strings

            // Metadata
            $table->unsignedSmallInteger('positions')
                  ->default(1)
                  ->comment('Number of open positions (1–100)');
            $table->string('location');                     // City / Region
            $table->string('duration', 100);                // e.g. "3 months", "6 weeks"
            $table->enum('internship_type', ['full_time', 'part_time', 'remote']);
            $table->date('deadline');                       // Application deadline

            // Workflow Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'closed'])
                  ->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->softDeletes(); // Allows recovery; physically removed on company delete
            $table->timestamps();

            // Indexes for common search queries
            $table->index(['status', 'deadline']);
            $table->index(['company_id', 'status']);
            $table->index('category_id');
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
