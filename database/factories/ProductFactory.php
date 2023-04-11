<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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
            'name' => $this->faker->sentence(3),
            'img_url' => $this->faker->imageUrl(640, 480, 'products', true, 'Faker'),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->paragraph,
            'category_id' => function() {
                return Category::inRandomOrder()->first()->id;
            },
         
        ];
    }
}
