<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\UnitType;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->sentence(),
            'category_id' => Category::inRandomOrder()->value('id'),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'unit_type_id' => UnitType::inRandomOrder()->value('id'),
            'description' => fake()->sentence(),
            'quantity' => fake()->numberBetween(10, 100),
            'price' => fake()->numberBetween(100, 10000),
        ];
    }
}
