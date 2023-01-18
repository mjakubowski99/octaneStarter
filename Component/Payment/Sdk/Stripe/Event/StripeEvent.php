<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\Event;

use Component\Payment\Sdk\Stripe\Intent\StripePaymentIntent;
use Component\Payment\Sdk\Stripe\ValueObject\EventType;

interface StripeEvent
{
    public function getType(): EventType;

    public function getPaymentIntentObject(): StripePaymentIntent;
}
