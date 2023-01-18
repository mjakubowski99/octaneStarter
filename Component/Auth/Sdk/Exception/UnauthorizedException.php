<?php

declare(strict_types=1);

namespace Component\Auth\Sdk\Exception;

use Common\Exception\ApiException;

class UnauthorizedException extends ApiException
{
    public function __construct()
    {
        parent::__construct("Unauthenticated", 403, []);
    }
}
