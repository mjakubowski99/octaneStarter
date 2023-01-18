<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Strategy\ReceiveWebhookNotification;

use Component\Payment\Domain\UseCase\UpdateOrderStatus;
use Component\Payment\Sdk\Contract\PaymentWebhookContract;
use Component\Payment\Sdk\Mapper\OrderStatusMapper;
use Component\Payment\Sdk\Stripe\Lib\Stripe;

class StripeReceiveWebhookNotificationStrategy implements ReceiveWebhookNotificationStrategy
{
    private Stripe $stripe;
    private UpdateOrderStatus $updateOrderStatus;

    public function __construct(Stripe $stripe, UpdateOrderStatus $updateOrderStatus)
    {
        $this->stripe = $stripe;
        $this->updateOrderStatus = $updateOrderStatus;
    }

    public function handle(PaymentWebhookContract $contract): void
    {
        $event = $this->stripe->constructWebhookEvent(
            $contract->getWebhookContent(),
            $contract->getWebhookSignature()
        );

        if ($event->getType()->isPaymentIntent()) {
            $intent = $event->getPaymentIntentObject();

            $orderStatusMapper = new OrderStatusMapper();

            $this->updateOrderStatus->handle(
                $intent->getIntentId(),
                $orderStatusMapper->mapStripeStatusToOrderStatus(
                    $intent->getStatus()
                ),
                $contract->getPaymentProvider()
            );
        }
    }
}
