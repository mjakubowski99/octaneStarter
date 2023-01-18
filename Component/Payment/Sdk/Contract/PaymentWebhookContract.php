<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Contract;

use Common\ValueObject\PaymentProvider;

interface PaymentWebhookContract
{
    public function getWebhookContent(): string;

    public function getWebhookSignature(): string;

    public function getPaymentProvider(): PaymentProvider;
}
