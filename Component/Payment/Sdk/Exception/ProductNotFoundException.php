<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Exception;

use Common\Exception\ApiException;
use Common\ValueObject\Uuid;

class ProductNotFoundException extends ApiException
{
    public const MESSAGE = "Product not found with id: ";

    public function __construct(Uuid $id, array $metadata = [])
    {
        parent::__construct(self::MESSAGE.$id, 404);
    }
}
