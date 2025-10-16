<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Generate HTML content for product fields.
     *
     * @return string
     */
    private function generateHtmlContent(): string
    {
        $paragraphs = $this->faker->numberBetween(2, 4);
        $html = '';

        for ($i = 0; $i < $paragraphs; $i++) {
            $html .= '<p>' . $this->faker->paragraph($this->faker->numberBetween(2, 5)) . '</p>';
        }

        // Add a list sometimes
        if ($this->faker->boolean(60)) {
            $html .= '<ul>';
            $items = $this->faker->numberBetween(3, 6);
            for ($j = 0; $j < $items; $j++) {
                $html .= '<li>' . $this->faker->sentence($this->faker->numberBetween(3, 8)) . '</li>';
            }
            $html .= '</ul>';
        }

        // Add another paragraph with some emphasis
        $text = $this->faker->paragraph(3);
        $words = explode(' ', $text);
        $randomIndex = $this->faker->numberBetween(0, count($words) - 3);
        $words[$randomIndex] = '<strong>' . $words[$randomIndex] . '</strong>';
        if ($this->faker->boolean(50)) {
            $randomIndex2 = $this->faker->numberBetween(0, count($words) - 3);
            if ($randomIndex2 !== $randomIndex) {
                $words[$randomIndex2] = '<em>' . $words[$randomIndex2] . '</em>';
            }
        }
        $html .= '<p>' . implode(' ', $words) . '</p>';

        return $html;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameAr = $this->faker->words(3, true);
        $nameEn = $this->faker->words(3, true);
        $discount = $this->faker->randomFloat(2, 0, 30);
        $price = $this->faker->randomFloat(2, 10, 500);
        $priceAfterDiscount = $price - ($price * $discount / 100);
        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => [
                'ar' => $nameAr,
                'en' => ucwords($nameEn),
                'he' => $nameEn,
            ],
            'slug' => Str::slug($nameEn),
            'description' => [
                'ar' => $this->faker->paragraph(3),
                'en' => $this->faker->paragraph(3),
                'he' => $this->faker->paragraph(3),
            ],
            'how_to_use' => [
                'ar' => $this->generateHtmlContent(),
                'en' => $this->generateHtmlContent(),
                'he' => $this->generateHtmlContent(),
            ],
            'details' => [
                'ar' => $this->generateHtmlContent(),
                'en' => $this->generateHtmlContent(),
                'he' => $this->generateHtmlContent(),
            ],
            'image' => null, // Will be set in seeder
            'discount' => $discount,
            'price' => $price,
            'price_after_discount' => $priceAfterDiscount,
            'featured' => $this->faker->boolean(30), // 30% chance of being featured
            'active' => $this->faker->boolean(80), // 80% chance of being active
            'order' => $this->faker->numberBetween(1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
            'rate_count' => $this->faker->numberBetween(0, 5),
        ];
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'featured' => true,
        ]);
    }

    /**
     * Indicate that the product is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => true,
        ]);
    }

    /**
     * Set a specific image for the product.
     */
    public function withImage(string $imagePath): static
    {
        return $this->state(fn(array $attributes) => [
            'image' => $imagePath,
        ]);
    }
}
