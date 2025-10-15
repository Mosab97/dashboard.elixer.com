<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RealResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RealResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $result1 = RealResult::create([
            'name' => [
                'en' => 'Acne Scar Treatment',
                'ar' => 'علاج علاج الحبوب',
                'he' => 'عלاج דפנות דפנות',
            ],
            'description' => [
                'en' => 'Amazing results! My acne scars have significantly faded and my skin looks so much smoother.',
                'ar' => 'نتائج رائعة! حبوب الحبوب قد اختفى بشكل كبير وجلدي بدأت تبدو أكثر نعومة.',
                'he' => 'תוצאות מדהימות! דפנות הדפנות קיבלו משנה משמעותית ופניי התחילו להיראות יותר חלק.',

            ],
            'image_before' => 'media/real-results/before01.jpg',
            'image_after' => 'media/real-results/after01.jpg',
            'duration' => '4 weeks',
            'active' => true,
        ]);
        $randomProducts = Product::inRandomOrder()->take(3)->pluck('id');
        $result1->products()->attach($randomProducts);
        $result2 = RealResult::create([
            'name' => [
                'en' => 'Dark Spots & Pigmentation',
                'ar' => 'نقاط سوداء والتوحيد',
                'he' => 'נקודות שחורות ואילוז',
            ],
            'description' => [
                'en' => 'The dark spots are almost completely gone. I can\'t believe the transformation!',
                'ar' => 'نقاط السواد قد اختفت تقريباً. لا يمكنني أن أصدق التحول!',
                'he' => 'נקודות השחור קיבלו משנה משמעותית ופניי התחילו להיראות יותר חלק.',
            ],
            'image_before' => 'media/real-results/before02.jpg',
            'image_after' => 'media/real-results/after02.jpg',
            'duration' => '6 weeks',
            'active' => true,
        ]);
        $randomProducts = Product::inRandomOrder()->take(3)->pluck('id');
        $result2->products()->attach($randomProducts);
    }
}
