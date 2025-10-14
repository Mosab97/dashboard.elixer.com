<?php

namespace Database\Factories;

use App\Models\FAQ;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FAQ>
 */
class FAQFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questionAr = $this->faker->sentence() . '؟';
        $questionEn = $this->faker->sentence() . '?';

        // Generate HTML content for answers with various HTML tags
        $htmlAnswers = [
            '<p>' . $this->faker->paragraph(3) . '</p><p>' . $this->faker->paragraph(2) . '</p>',
            '<p>' . $this->faker->paragraph(2) . '</p><ul><li>' . $this->faker->sentence() . '</li><li>' . $this->faker->sentence() . '</li><li>' . $this->faker->sentence() . '</li></ul>',
            '<p><strong>' . $this->faker->sentence() . '</strong></p><p>' . $this->faker->paragraph(3) . '</p>',
            '<h3>' . $this->faker->words(3, true) . '</h3><p>' . $this->faker->paragraph(2) . '</p><ol><li>' . $this->faker->sentence() . '</li><li>' . $this->faker->sentence() . '</li></ol>',
            '<p>' . $this->faker->paragraph(2) . '</p><blockquote>' . $this->faker->sentence() . '</blockquote><p>' . $this->faker->paragraph(1) . '</p>',
        ];

        $answerHtml = $this->faker->randomElement($htmlAnswers);

        return [
            'question' => [
                'ar' => $questionAr,
                'en' => $questionEn,
                'he' => $questionEn,
            ],
            'answer' => [
                'ar' => $answerHtml,
                'en' => $answerHtml,
                'he' => $answerHtml,
            ],
            'active' => $this->faker->boolean(85), // 85% chance of being active
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the FAQ is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => true,
        ]);
    }

    /**
     * Indicate that the FAQ is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}

