<?php

declare(strict_types=1);

namespace Database\Seeders;

use Common\ValueObject\Currency;
use Component\Payment\Infrastracture\Entities\Product;
use Component\Product\Infrastructure\Entities\ProductDetail;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::factory()->create([
            'amount' => 10000,
            'currency' => Currency::pln()->getValue()
        ]);
        ProductDetail::factory()->create([
            'product_id' => $product->id,
            'name' => 'Szminka',
            'description' => 'Idealna na specjalne okazje',
            'image_url' => 'products/szminka.jpg'
        ]);

        $product = Product::factory()->create([
            'amount' => 200000,
            'currency' => Currency::pln()->getValue()
        ]);
        ProductDetail::factory()->create([
            'product_id' => $product->id,
            'name' => 'Laptop',
            'description' => 'Dla komputerowców',
            'image_url' => 'products/laptop.jpg'
        ]);

        $product = Product::factory()->create([
            'amount' => 200,
            'currency' => Currency::pln()->getValue()
        ]);
        ProductDetail::factory()->create([
            'product_id' => $product->id,
            'name' => 'Sruby',
            'description' => 'Dla majsterkowiczów',
            'image_url' => 'products/sruby.jpg'
        ]);
    }
}
