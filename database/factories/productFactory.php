<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_en'=>fake()->name(),
            'name_ar'=>fake()->name(),
            'description_en'=>fake()->text(),
            'description_ar'=>fake()->text(),
            'image_url'=>fake()->image(),
            'active'=>fake()->boolean(),
        ];
    }
}
