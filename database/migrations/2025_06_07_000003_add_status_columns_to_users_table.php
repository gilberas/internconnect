<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add account status and suspension columns to the users table.
     * Supports FR18 (Account Suspension Management).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_type')->default('student')->after('email'); // 'student' | 'company' | 'admin'
            $table->enum('status', ['active', 'suspended'])->default('active')->after('account_type');
            $table->text('suspended_reason')->nullable()->after('status');
            $table->timestamp('suspended_at')->nullable()->after('suspended_reason');
            $table->unsignedBigInteger('suspended_by')->nullable()->after('suspended_at');
            $table->foreign('suspended_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['suspended_by']);
            $table->dropColumn(['account_type', 'status', 'suspended_reason', 'suspended_at', 'suspended_by']);
        });
    }
};
