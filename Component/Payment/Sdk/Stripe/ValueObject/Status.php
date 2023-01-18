<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\ValueObject;

use Component\Payment\Sdk\Exception\InvalidValueObjectValueException;

final class Status
{
    private const PAYMENT_INTENT_REQUIRES_PAYMENT_METHOD = "requires_payment_method";
    private const PAYMENT_INTENT_SUCCEEDED = "succeeded";
    private const PAYMENT_INTENT_CANCELED = "canceled";
    private const PAYMENT_INTENT_PROCESSING = "processing";

    private const AVAILABLE = [
        self::PAYMENT_INTENT_REQUIRES_PAYMENT_METHOD,
        self::PAYMENT_INTENT_SUCCEEDED,
        self::PAYMENT_INTENT_PROCESSING,
        self::PAYMENT_INTENT_CANCELED
    ];

    private const AVAILABLE_FOR_PAYMENT_INTENT = [
        self::PAYMENT_INTENT_REQUIRES_PAYMENT_METHOD,
        self::PAYMENT_INTENT_SUCCEEDED,
        self::PAYMENT_INTENT_PROCESSING,
        self::PAYMENT_INTENT_CANCELED
    ];

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isStatusForPaymentIntent(): bool
    {
        return in_array($this->value, self::AVAILABLE_FOR_PAYMENT_INTENT);
    }

    public function isRequiresPaymentMethod(): bool
    {
        return $this->value === self::PAYMENT_INTENT_REQUIRES_PAYMENT_METHOD;
    }

    public function isPaymentIntentProcessing(): bool
    {
        return $this->value === self::PAYMENT_INTENT_PROCESSING;
    }

    public function isPaymentIntentSucceeded(): bool
    {
        return $this->value === self::PAYMENT_INTENT_SUCCEEDED;
    }

    public function isPaymentIntentCanceled(): bool
    {
        return $this->value === self::PAYMENT_INTENT_CANCELED;
    }


    public static function getAvailableForPaymentIntent(): array
    {
        return self::AVAILABLE_FOR_PAYMENT_INTENT;
    }

    public static function paymentIntentSucceeded(): self
    {
        return new self(self::PAYMENT_INTENT_SUCCEEDED);
    }

    public static function paymentIntentProcessing(): self
    {
        return new self(self::PAYMENT_INTENT_PROCESSING);
    }

    public static function paymentIntentCanceled(): self
    {
        return new self(self::PAYMENT_INTENT_PROCESSING);
    }

    public static function getAvailableForValidation(): string
    {
        return implode(",", self::AVAILABLE);
    }

    private function validate(string $value): void
    {
        if( !in_array($value, self::AVAILABLE) ){
            throw new InvalidValueObjectValueException($value, self::class, self::getAvailableForValidation());
        }
    }
}
