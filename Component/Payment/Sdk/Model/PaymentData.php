<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Model;

use Common\ValueObject\OrderStatus;

class PaymentData
{
    private string $paymentProviderOrderId;

    private OrderStatus $orderStatus;

    public function __construct(string $paymentProviderOrderId, OrderStatus $orderStatus)
    {
        $this->paymentProviderOrderId = $paymentProviderOrderId;
        $this->orderStatus = $orderStatus;
    }

    public function getPaymentProviderOrderId(): string
    {
        return $this->paymentProviderOrderId;
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }
}
