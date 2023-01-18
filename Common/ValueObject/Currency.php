<?php

declare(strict_types=1);

namespace Common\ValueObject;

use Common\Exception\InvalidArgumentException;

final class Currency
{
    private const PLN = "PLN";

    private const AVAILABLE = [
        self::PLN
    ];

    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = strtoupper($value);
    }

    public function equals(Currency $currency): bool
    {
        return $this->value === $currency->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function pln(): Currency
    {
        return new self(self::PLN);
    }

    public static function getAvailableForValidation(): string
    {
        return implode(",", self::AVAILABLE);
    }

    private function validate(string $value): void
    {
        if( !in_array($value, self::AVAILABLE) ){
            throw new InvalidArgumentException(
                "Value {$value} is not available for Currency. Available values: ".self::getAvailableForValidation()
            );
        }
    }
}
