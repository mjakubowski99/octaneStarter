<?php

declare(strict_types=1);

namespace Component\Auth\Sdk;

use Component\Auth\Sdk\Model\Authenticate;

interface AuthFacade
{
    public function current(): Authenticate;
}
