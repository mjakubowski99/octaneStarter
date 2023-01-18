<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Exception;

use Common\Exception\ApiException;

class OrderNotFoundException extends ApiException
{
    public const MESSAGE = "Order not found with payment_provider_order_id: ";

    public function __construct(string $paymentProviderOrderId, array $metadata = [])
    {
        parent::__construct(self::MESSAGE.$paymentProviderOrderId, 404, $metadata);
    }
}
