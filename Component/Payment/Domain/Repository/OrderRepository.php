<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Repository;

use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\OrderWrite;

interface OrderRepository
{
    public function create(OrderWrite $orderWrite): OrderRead;

    public function getPaymentReceiverPaymentProviderAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string;

    public function findByPaymentProviderOrderId(string $paymentProviderOrderId): OrderRead;

    public function getOrderStatusByPaymentProviderOrderId(string $paymentProviderOrderId): OrderStatus;

    public function updateStatusByPaymentProviderOrderId(string $paymentProviderOrderId, OrderStatus $orderStatus): OrderRead;
}
