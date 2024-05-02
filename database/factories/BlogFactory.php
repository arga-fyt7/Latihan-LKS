<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'date' => $this->faker->date,
            'attachment' => $this->faker->randomElement([$this->faker->imageUrl(), null]),
            'tags' => $this->faker->words(3, true),
            'contents' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['Created', 'Processing', 'Published']),
        ];
    }
}
