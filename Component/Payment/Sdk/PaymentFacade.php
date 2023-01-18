<?php

declare(strict_types=1);

namespace Component\Payment\Sdk;

use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Contract\CreateOrderContract;
use Component\Payment\Sdk\Contract\PaymentWebhookContract;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\StripePaymentIntentReadModel;

interface PaymentFacade
{
    public function createOrder(CreateOrderContract $contract, Uuid $userId): OrderRead;

    public function getOrderPaymentReceiverAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string;

    public function receiveWebhookNotification(PaymentWebhookContract $contract): void;

    public function getStripePaymentIntentReadModel(OrderRead $orderRead): StripePaymentIntentReadModel;
}
