<?php

declare(strict_types=1);

namespace Component\Auth\Domain;

use Component\Auth\Infrastructure\UserProvider\UserProvider;
use Component\Auth\Sdk\AuthFacade;
use Component\Auth\Sdk\Model\Authenticate;

class AuthFacadeImpl implements AuthFacade
{
    private UserProvider $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function current(): Authenticate
    {
        return $this->userProvider->current();
    }
}
