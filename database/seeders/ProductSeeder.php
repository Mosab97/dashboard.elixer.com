<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create 20 products with images numbered 1-20.png
        for ($i = 1; $i <= 20; $i++) {
            Product::factory()
                ->withImage('media/products/' . $i . '.png')
                ->create();
        }
    }
}
