<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the internship_categories table.
     * Supports FR17 (Internship Category Management).
     *
     * Seed initial categories after migration:
     *   php artisan db:seed --class=InternshipCategorySeeder
     */
    public function up(): void
    {
        Schema::create('internship_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();       // e.g. ICT, Health, Finance, Engineering
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();     // Optional Heroicon or emoji for UI
            $table->boolean('is_active')->default(true); // Deactivated = hidden from forms, kept for history
            $table->unsignedInteger('sort_order')->default(0); // Display order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_categories');
    }
};
