<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $demoUsers = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@internconnect.test',
                'account_type' => 'admin',
                'role' => 'super-admin',
                'status' => 'active',
            ],
            [
                'name' => 'System Administrator',
                'email' => 'admin@internconnect.test',
                'account_type' => 'admin',
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Tech Solutions Ltd',
                'email' => 'employer@internconnect.test',
                'account_type' => 'company',
                'role' => 'company',
                'status' => 'active',
            ],
            [
                'name' => 'John Applicant',
                'email' => 'jobseeker@internconnect.test',
                'account_type' => 'student',
                'role' => 'student',
                'status' => 'active',
            ],
        ];

        foreach ($demoUsers as $demo) {
            $user = User::updateOrCreate(
                ['email' => $demo['email']],
                [
                    'name' => $demo['name'],
                    'password' => Hash::make('Password@123'),
                    'account_type' => $demo['account_type'],
                    'status' => $demo['status'],
                    'email_verified_at' => $now,
                ]
            );

            $user->assignRole($demo['role']);
        }

        $this->command->info('Demo users seeded successfully.');
    }
}
