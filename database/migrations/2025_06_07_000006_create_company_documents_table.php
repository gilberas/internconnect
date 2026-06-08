<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the company_documents table.
     * Stores BRELA, NIDA, TRA and other verification documents.
     * Supports FR4 (Company Registration).
     */
    public function up(): void
    {
        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                  ->constrained('company_profiles')
                  ->cascadeOnDelete();

            $table->enum('document_type', ['brela', 'nida', 'tra', 'other']);
            $table->string('original_filename', 255); // Original uploaded filename for display
            $table->string('file_path', 500);         // Secure storage path (outside public/)
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('file_size')->nullable(); // in bytes

            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_documents');
    }
};
