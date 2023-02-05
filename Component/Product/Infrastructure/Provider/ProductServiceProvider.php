<?php

namespace Component\Product\Infrastructure\Provider;

use Component\Payment\Sdk\Event\OrderSucceeded;
use Component\Product\Domain\Repository\ProductRepository;
use Component\Product\Infrastructure\Listener\OrderSucceededListener;
use Component\Product\Infrastructure\Repositories\ProductRepositoryImpl;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ProductRepository::class => ProductRepositoryImpl::class
    ];

    public function boot(): void
    {
        Event::listen(
            OrderSucceeded::class,
            [OrderSucceededListener::class, 'handle']
        );
    }
}
