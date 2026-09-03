<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permissions ─────────────────────────────────────────────────
        $permissions = [
            // Student
            'manage own profile', 'upload documents', 'search internships',
            'apply internships', 'save internships', 'track applications',

            // Company
            'manage company profile', 'upload company documents', 'post internships',
            'review applicants', 'schedule interviews',

            // Admin
            'verify companies', 'approve internships', 'manage users',
            'manage categories', 'generate reports', 'view activity logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ── Roles ────────────────────────────────────────────────────────
        $student = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $student->syncPermissions([
            'manage own profile', 'upload documents', 'search internships',
            'apply internships', 'save internships', 'track applications',
        ]);

        $company = Role::firstOrCreate(['name' => 'company', 'guard_name' => 'web']);
        $company->syncPermissions([
            'manage company profile', 'upload company documents', 'post internships',
            'review applicants', 'schedule interviews',
        ]);

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
