<?php

declare(strict_types=1);

namespace Common\ValueObject;

use Common\Exception\InvalidArgumentException;

final class PaymentMethod
{
    private const CARD = "card";

    private const AVAILABLE = [
        self::CARD
    ];

    private const AVAILABLE_FOR_STRIPE = [
        self::CARD
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

    public static function getAvailableForStripe(): array
    {
        return self::AVAILABLE_FOR_STRIPE;
    }

    public static function getAvailableForValidation(): string
    {
        return implode(",", self::AVAILABLE);
    }

    private function validate(string $value): void
    {
        if( !in_array($this->value, self::AVAILABLE) ){
            throw new InvalidArgumentException(
                "Value {$value} is not available for PaymentMethod. Available values: ".self::getAvailableForValidation()
            );
        }
    }
}
