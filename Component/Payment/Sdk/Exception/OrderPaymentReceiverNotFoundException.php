<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Exception;

use Common\Exception\ApiException;
use Common\ValueObject\Uuid;

class OrderPaymentReceiverNotFoundException extends ApiException
{
    public const MESSAGE = "Order payment receiver not found for order with id: ";

    public function __construct(Uuid $orderId, array $metadata = [])
    {
        parent::__construct(self::MESSAGE.$orderId, 404, $metadata);
    }
}
