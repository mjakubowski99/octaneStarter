<?php

declare(strict_types=1);

namespace Component\Product\Infrastructure\Listener;

use Carbon\Carbon;
use Component\Payment\Sdk\Event\OrderSucceeded;
use Illuminate\Support\Facades\DB;

class OrderSucceededListener
{
    public function handle(OrderSucceeded $orderSucceeded): void
    {
        DB::table('user_products')->insert([
            [
                'product_id' => $orderSucceeded->getOrderRead()->getProductId(),
                'user_id' => $orderSucceeded->getOrderRead()->getBuyerId(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
