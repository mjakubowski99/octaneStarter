<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\Intent;

use Common\Exception\InvalidArgumentException;
use Component\Payment\Sdk\Stripe\ValueObject\Status;

class StripePaymentIntent
{
    private string $id;

    private Status $status;

    private ?string $paymentReceiverId;

    public function __construct(string $id, Status $status, ?string $paymentReceiverId)
    {
        if (!$status->isStatusForPaymentIntent()) {
            throw new InvalidArgumentException("Attempted to construct StripePaymentIntent object with invalid status");
        }
        $this->id = $id;
        $this->status = $status;
        $this->paymentReceiverId = $paymentReceiverId;
    }

    public function getIntentId(): string
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function hasPaymentReceiver(): bool
    {
        return $this->paymentReceiverId !== null;
    }

    public function getPaymentReceiverId(): string
    {
        return $this->paymentReceiverId;
    }
}
