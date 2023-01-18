<?php

declare(strict_types=1);

namespace Common\ValueObject;

use Common\Exception\InvalidArgumentException;

final class PaymentProvider
{
    private const STRIPE = 1;

    /** @var string[] */
    private const AVAILABLE = [
        self::STRIPE
    ];

    /** @var array<int, string> */
    private const VALUE_TO_NAME = [
        self::STRIPE => 'stripe'
    ];

    private int $value;

    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getName(): string
    {
        return self::VALUE_TO_NAME[$this->value];
    }

    public function isStripe(): bool
    {
        return $this->value === self::STRIPE;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function stripe(): self
    {
        return new self(self::STRIPE);
    }

    public static function getValueToNameAssociation(): array
    {
        return self::VALUE_TO_NAME;
    }

    public static function getAvailableForValidation(): string
    {
        return implode(",", self::AVAILABLE);
    }

    private function validate(int $value): void
    {
        if( !in_array($value, self::AVAILABLE) ){
            throw new InvalidArgumentException(
                "Value {$value} is not available for PaymentProvider. Available values: ".self::getAvailableForValidation()
            );
        }
    }
}
