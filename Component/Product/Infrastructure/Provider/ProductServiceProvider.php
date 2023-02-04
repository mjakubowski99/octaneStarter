<?php

namespace Component\Product\Infrastructure\Provider;

use Component\Product\Domain\Repository\ProductRepository;
use Component\Product\Infrastructure\Repositories\ProductRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ProductRepository::class => ProductRepositoryImpl::class
    ];
}
