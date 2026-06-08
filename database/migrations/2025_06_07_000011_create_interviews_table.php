<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the interviews table.
     * Supports FR11 (Interview Scheduling).
     *
     * Status lifecycle:
     *   scheduled -> confirmed -> completed
     *   scheduled -> rescheduled -> scheduled (loop)
     *   scheduled -> cancelled
     */
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();

            // Each interview belongs to one application (one-to-one)
            $table->foreignId('application_id')
                  ->constrained('applications')
                  ->cascadeOnDelete()
                  ->unique();

            // Schedule
            $table->date('interview_date');
            $table->time('interview_time');
            $table->enum('interview_type', ['physical', 'online', 'phone']);

            // Location / Link
            $table->string('venue', 255)->nullable();       // Required when type = physical
            $table->string('meeting_link', 500)->nullable(); // Required when type = online
            $table->text('instructions')->nullable();

            // Status
            $table->enum('status', [
                'scheduled',
                'confirmed',
                'rescheduled',
                'completed',
                'cancelled',
            ])->default('scheduled');

            // Rescheduling history (JSON array of previous datetime + reason)
            $table->json('reschedule_history')->nullable();

            $table->timestamps();

            $table->index(['interview_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
