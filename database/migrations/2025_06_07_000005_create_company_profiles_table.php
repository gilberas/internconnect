<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the company_profiles table.
     * Supports FR4 (Company Registration) and FR5 (Company Verification Workflow).
     */
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();

            // Company Identity
            $table->string('company_name');
            $table->string('registration_number', 100)->unique(); // BRELA registration number
            $table->string('contact_person'); // HR manager / representative name
            $table->text('address');
            $table->string('phone', 20);

            // Optional Details
            $table->string('website', 255)->nullable();
            $table->string('logo_path', 500)->nullable();
            $table->json('social_links')->nullable(); // { linkedin, twitter, facebook }

            // Verification
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
