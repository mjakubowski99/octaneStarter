<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Strategy\ReceiveWebhookNotification;

use Component\Payment\Sdk\Contract\PaymentWebhookContract;

interface ReceiveWebhookNotificationStrategy
{
    public function handle(PaymentWebhookContract $contract): void;
}
