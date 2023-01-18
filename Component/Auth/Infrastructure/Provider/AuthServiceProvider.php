<?php

declare(strict_types=1);

namespace Component\Auth\Infrastructure\Provider;

use Component\Auth\Domain\AuthFacadeImpl;
use Component\Auth\Infrastructure\UserProvider\UserProvider;
use Component\Auth\Infrastructure\UserProvider\UserProviderImpl;
use Component\Auth\Sdk\AuthFacade;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserProvider::class => UserProviderImpl::class,
        AuthFacade::class => AuthFacadeImpl::class,
    ];
}
