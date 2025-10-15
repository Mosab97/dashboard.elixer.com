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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameAr = $this->faker->words(3, true);
        $nameEn = $this->faker->words(3, true);

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
            'image' => null, // Will be set in seeder
            'discount' => $this->faker->randomFloat(2, 0, 30),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'featured' => $this->faker->boolean(30), // 30% chance of being featured
            'active' => $this->faker->boolean(80), // 80% chance of being active
            'order' => $this->faker->numberBetween(1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
            'rate_count' => $this->faker->numberBetween(0, 100),
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
