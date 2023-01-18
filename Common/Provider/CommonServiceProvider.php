<?php

declare(strict_types=1);

namespace Common\Provider;

use Common\Bus\EventBus\EventBus;
use Common\Bus\EventBus\EventBusImpl;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public array $bindings = [
        EventBus::class => EventBusImpl::class
    ];
}
