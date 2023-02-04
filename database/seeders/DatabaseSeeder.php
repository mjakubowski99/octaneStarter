<?php

declare(strict_types=1);

namespace Database\Seeders;

use Component\Payment\Infrastracture\Entities\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PaymentProviderTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
