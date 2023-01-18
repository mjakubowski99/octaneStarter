<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\Lib;

use Component\Payment\Sdk\Stripe\Event\StripeEvent;
use Component\Payment\Sdk\Stripe\Intent\StripePaymentIntent;

interface Stripe
{
    public function createPaymentIntent(array $data, array $opts): StripePaymentIntent;

    public function constructWebhookEvent(string $requestContent, string $httpSignature): StripeEvent;
}
