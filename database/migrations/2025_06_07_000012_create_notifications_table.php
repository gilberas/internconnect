<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the notifications table for in-app notifications.
     * Supports FR12 (Notification System).
     *
     * This table stores the 'database' channel notifications used by Laravel's
     * built-in notification system alongside custom metadata for the ICS UI.
     *
     * Usage in code:
     *   $user->notify(new CompanyVerifiedNotification($company));
     *
     * Read via:
     *   $user->notifications          // all
     *   $user->unreadNotifications    // unread only
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Laravel uses UUID for notifications
            $table->string('type');        // Notification class name

            // Polymorphic notifiable (usually User)
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');

            // Readable data for the ICS notification bell UI
            $table->string('title', 255);
            $table->text('message');
            $table->json('data')->nullable(); // Extra structured data (route, model ID, etc.)

            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['notifiable_type', 'notifiable_id', 'read_at'],
                          'notifications_notifiable_read_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
