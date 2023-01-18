<?php

namespace Component\Payment\Sdk\Exception;

use Common\Exception\InvalidArgumentException;

class InvalidValueObjectValueException extends InvalidArgumentException
{
    public function __construct(string $value, string $className, string $availableValues, int $statusCode = 400, array $metadata = [])
    {
        parent::__construct(
            "Value {$value} is not available for {$className}. Available values: {$availableValues}",
            $statusCode,
            $metadata
        );
    }
}
