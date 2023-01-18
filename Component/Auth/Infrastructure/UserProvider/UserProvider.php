<?php

declare(strict_types=1);

namespace Component\Auth\Infrastructure\UserProvider;

use Component\Auth\Sdk\Model\Authenticate;

interface UserProvider
{
    public function current(): Authenticate;
}
