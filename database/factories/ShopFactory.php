<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'color' => $this->faker->hexColor(),
            'attachment' => $this->faker->randomElement([$this->faker->imageUrl(), null]),
            'sku' => $this->faker->unique()->uuid,
            'category' => $this->faker->word(),
            'tags' => $this->faker->words(3, true),
            'contents' => $this->faker->paragraphs(3, true),
        ];
    }
}
