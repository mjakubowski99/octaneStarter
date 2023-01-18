<?php

namespace Database\Factories;

use Common\ValueObject\Currency;
use Common\ValueObject\Uuid;
use Component\Payment\Infrastracture\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'id' => new Uuid(),
            'amount' => random_int(100, 10000),
            'currency' => Currency::pln()->getValue(),
            'active' => true
        ];
    }
}
