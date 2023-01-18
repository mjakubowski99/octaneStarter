<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Model;

use Common\ValueObject\OrderStatus;

class UpdateOrderModel
{
    private string $paymentProviderOrderId;

    private OrderStatus $paymentProviderOrderStatus;

    public function __construct(string $paymentProviderOrderId, OrderStatus $paymentProviderOrderStatus)
    {
        $this->paymentProviderOrderId = $paymentProviderOrderId;
        $this->paymentProviderOrderStatus = $paymentProviderOrderStatus;
    }

    public function getPaymentProviderOrderId(): string
    {
        return $this->paymentProviderOrderId;
    }

    public function getPaymentProviderOrderStatus(): OrderStatus
    {
        return $this->paymentProviderOrderStatus;
    }
}
