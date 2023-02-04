<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Service;

use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\PaymentData;
use Component\Payment\Sdk\Model\StripePaymentIntentReadModel;

interface PaymentService
{
    public function getOrderPaymentReceiverAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string;

    public function getPublishableKeyForPaymentProvider(PaymentProvider $paymentProvider);

    public function getStripePaymentIntentReadModel(PaymentData $paymentData): StripePaymentIntentReadModel;
}
