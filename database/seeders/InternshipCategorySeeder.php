<?php

namespace Database\Seeders;

use App\Models\InternshipCategory;
use Illuminate\Database\Seeder;

class InternshipCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Information & Communication Technology', 'sort_order' => 1],
            ['name' => 'Engineering & Manufacturing',           'sort_order' => 2],
            ['name' => 'Finance & Accounting',                  'sort_order' => 3],
            ['name' => 'Health & Medical Sciences',             'sort_order' => 4],
            ['name' => 'Business & Management',                 'sort_order' => 5],
            ['name' => 'Education & Training',                  'sort_order' => 6],
            ['name' => 'Legal & Compliance',                    'sort_order' => 7],
            ['name' => 'Media, Arts & Design',                  'sort_order' => 8],
            ['name' => 'Agriculture & Environment',             'sort_order' => 9],
            ['name' => 'Social Work & NGOs',                    'sort_order' => 10],
            ['name' => 'Hospitality & Tourism',                 'sort_order' => 11],
            ['name' => 'Marketing & Communications',            'sort_order' => 12],
        ];

        foreach ($categories as $cat) {
            InternshipCategory::firstOrCreate(
                ['name' => $cat['name']],
                $cat + ['is_active' => true]
            );
        }

        $this->command->info('Internship categories seeded.');
    }
}
