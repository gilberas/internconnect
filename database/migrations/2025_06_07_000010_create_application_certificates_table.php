<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the application_certificates table.
     * Stores supporting certificate files attached to applications (up to 5).
     * Supports FR9.2 (Additional supporting documents per application).
     */
    public function up(): void
    {
        Schema::create('application_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                  ->constrained('applications')
                  ->cascadeOnDelete();
            $table->string('original_filename', 255);
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_certificates');
    }
};
