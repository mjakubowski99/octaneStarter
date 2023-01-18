<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Http\Request\Stripe;

use Common\Exception\InvalidArgumentException;
use Common\ValueObject\PaymentProvider;
use Component\Payment\Sdk\Contract\PaymentWebhookContract;
use Illuminate\Foundation\Http\FormRequest;

class StripeWebhookNotificationRequest extends FormRequest implements PaymentWebhookContract
{
    public function getWebhookContent(): string
    {
        return $this->getContent();
    }

    public function getWebhookSignature(): string
    {
        if (!array_key_exists('HTTP_STRIPE_SIGNATURE', $_SERVER)) {
            throw new InvalidArgumentException("Webhook signature is not passed");
        }
        return $_SERVER['HTTP_STRIPE_SIGNATURE'];
    }

    public function getPaymentProvider(): PaymentProvider
    {
        return PaymentProvider::stripe();
    }
}
