<?php

namespace Modules\Stock\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Stock\Models\Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

