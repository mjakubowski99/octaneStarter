<?php

declare(strict_types=1);

namespace Database\Factories;

use Component\Product\Infrastructure\Entities\ProductDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDetailFactory extends Factory
{

    protected $model = ProductDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [];
    }
}
