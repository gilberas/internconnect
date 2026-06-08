<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the activity_logs table.
     * Supports NFR-07 (Error Logging) and the admin Activity Log viewer.
     *
     * Log key events using:
     *   ActivityLog::record('login', $user);
     *   ActivityLog::record('verify_company', $admin, $company);
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Who performed the action (null = unauthenticated / system)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // What was done
            $table->string('action', 100); // e.g. login, logout, verify_company, approve_internship

            // What was acted upon (polymorphic)
            $table->string('subject_type', 100)->nullable(); // e.g. App\Models\Company
            $table->unsignedBigInteger('subject_id')->nullable();

            // Request context
            $table->string('ip_address', 45)->nullable();  // Supports IPv6
            $table->string('user_agent', 500)->nullable();
            $table->json('extra')->nullable(); // Additional context data

            $table->timestamp('created_at')->useCurrent();

            // No updated_at needed (logs are immutable)
            $table->index(['user_id', 'action']);
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
