<?php

namespace Component\Payment\Sdk\Mapper;

use Common\Exception\InvalidArgumentException;
use Common\ValueObject\OrderStatus;
use Component\Payment\Sdk\Stripe\ValueObject\Status;

final class OrderStatusMapper
{
    public function mapStripeStatusToOrderStatus(Status $status): OrderStatus
    {
        if ($status->isRequiresPaymentMethod()) {
            return OrderStatus::created();
        }
        if ($status->isPaymentIntentSucceeded()) {
            return OrderStatus::succeeded();
        } elseif ($status->isPaymentIntentProcessing()) {
            return OrderStatus::cancelled();
        } elseif ($status->isPaymentIntentCanceled()) {
            return OrderStatus::cancelled();
        }

        throw new InvalidArgumentException("Given stripe status: {$status->getValue()} does not have any corresponding order status");
    }
}
