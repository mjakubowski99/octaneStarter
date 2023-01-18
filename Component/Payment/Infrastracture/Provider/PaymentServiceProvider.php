<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Provider;

use Component\Payment\Domain\PaymentFacadeImpl;
use Component\Payment\Domain\Repository\OrderRepository;
use Component\Payment\Domain\Repository\ProductRepository;
use Component\Payment\Domain\Service\PaymentService;
use Component\Payment\Domain\Service\PaymentServiceImpl;
use Component\Payment\Infrastracture\Repository\OrderRepositoryImpl;
use Component\Payment\Infrastracture\Repository\ProductRepositoryImpl;
use Component\Payment\Sdk\PaymentFacade;
use Component\Payment\Sdk\Stripe\Lib\Stripe;
use Component\Payment\Sdk\Stripe\Lib\StripeImpl;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PaymentFacade::class => PaymentFacadeImpl::class,
        PaymentService::class => PaymentServiceImpl::class,
        ProductRepository::class => ProductRepositoryImpl::class,
        OrderRepository::class => OrderRepositoryImpl::class,
        Stripe::class => StripeImpl::class
    ];
}
