<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\ValueObject;

use Common\Exception\InvalidArgumentException;

final class EventType
{
    private const PAYMENT_INTENT = "payment_intent";

    private const AVAILABLE = [
        self::PAYMENT_INTENT
    ];

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isPaymentIntent(): bool
    {
        return $this->value === self::PAYMENT_INTENT;
    }

    public static function paymentIntent(): self
    {
        return new self(self::PAYMENT_INTENT);
    }

    public static function getAvailableForValidation(): string
    {
        return implode(",", self::AVAILABLE);
    }

    private function validate(string $value): void
    {
        if( !in_array($this->value, self::AVAILABLE) ){
            throw new InvalidArgumentException(
                "Value {$value} is not available for EventType. Available values: ".self::getAvailableForValidation()
            );
        }
    }
}
