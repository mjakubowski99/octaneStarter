<?php

declare(strict_types=1);

namespace Component\Payment\Domain\UseCase;

use Common\Exception\InvalidArgumentException;
use Common\ValueObject\PaymentProvider;
use Component\Payment\Domain\Strategy\ReceiveWebhookNotification\ReceiveWebhookNotificationStrategy;
use Component\Payment\Domain\Strategy\ReceiveWebhookNotification\StripeReceiveWebhookNotificationStrategy;
use Component\Payment\Sdk\Contract\PaymentWebhookContract;

final class ReceiveWebhookNotification
{
    private StripeReceiveWebhookNotificationStrategy $receiveWebhookNotificationStrategy;

    public function __construct(StripeReceiveWebhookNotificationStrategy $stripeReceiveWebhookNotificationStrategy)
    {
        $this->receiveWebhookNotificationStrategy = $stripeReceiveWebhookNotificationStrategy;
    }
    
    public function handle(PaymentWebhookContract $contract): void
    {
        $this->getStrategyByPaymentProvider($contract->getPaymentProvider())->handle($contract);
    }

    private function getStrategyByPaymentProvider(PaymentProvider $paymentProvider): ReceiveWebhookNotificationStrategy
    {
        if ($paymentProvider->isStripe()) {
            return $this->receiveWebhookNotificationStrategy;
        }
        throw new InvalidArgumentException("Receiving webhook notifications is not possible for: {$paymentProvider} payment provider");
    }
}
