<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'ar' => 'المنظفات',
                    'en' => 'Cleanser',
                    'he' => 'מסכן',
                ],
                'active' => true,
                'order' => 1,
            ],
            [
                'name' => [
                    'ar' => 'مصل',
                    'en' => 'Serum',
                    'he' => 'מסכן',
                ],
                'active' => true,
                'order' => 2,
            ],
            [
                'name' => [
                    'ar' => 'واقي الشمس',
                    'en' => 'Sunscreen',
                    'he' => 'מסכן',
                ],
                'active' => true,
                'order' => 3,
             ],
            [
                'name' => [
                    'ar' => 'مرطب',
                    'en' => 'Moisturizer',
                    'he' => 'מסכן',
                ],
                'active' => true,
                'order' => 4,
            ],

        ];
        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $this->command->info('Categories seeder completed successfully!');
    }
}
