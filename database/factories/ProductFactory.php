<?php

namespace Database\Factories;

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
    public function definition()
    {
        $productName = $this->faker->unique()->sentence(3, false);
        return [
            'name' => $productName,
            'image' => $this->faker->imageUrl(height: 200, width: 200, gray: true), //https://picsum.photos/300/300
            'slug' => Str::slug($productName),
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
