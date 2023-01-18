<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Model;

use Common\Util\Arrayable;

class StripePaymentIntentReadModel implements Arrayable
{
    private string $publishableKey;

    private string $paymentIntentId;

    private ?string $connectedAccountId;

    public function __construct(
        string $publishableKey,
        string $paymentIntentId,
        ?string $connectedAccountId
    )
    {
        $this->publishableKey = $publishableKey;
        $this->paymentIntentId = $paymentIntentId;
        $this->connectedAccountId = $connectedAccountId;
    }

    public function toArray(): array
    {
        return [
            'publishableKey' => $this->publishableKey,
            'paymentIntentId' => $this->paymentIntentId,
            'connectedAccountId' => $this->connectedAccountId
        ];
    }
}
