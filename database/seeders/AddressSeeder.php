<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'title' => [
                    'ar' => 'الداخل',
                    'en' => 'israel',
                    'he' => 'ישראל',
                ],
                'price' => 60,
                'active' => true,
                'order' => 1,
            ],
            [
                'title' => [
                    'ar' => 'الضفة',
                    'en' => 'westban',
                    'he' => 'ויסטבן',
                ],
                'price' => 20,
                'active' => true,
                'order' => 2,
            ],
            [
                'title' => [
                    'ar' => 'ابو غوش',
                    'en' => 'Abu Gharb',
                    'he' => 'אבו גרב',
                ],
                'price' => 40,
                'active' => true,
                'order' => 3,
            ],
        ];
        foreach ($addresses as $addressData) {
            Address::create($addressData);
        }
        $this->command->info('Addresses seeder completed successfully!');
    }
}
