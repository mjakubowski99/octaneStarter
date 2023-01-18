<?php

declare(strict_types=1);

namespace Common\ValueObject;

use Common\Exception\InvalidArgumentException;

final class OrderStatus
{
    private const CREATED = 1;
    private const PROCESSING = 2;
    private const SUCCEEDED = 3;
    private const FAILED = 4;
    private const CANCELLED = 5;

    private const AVAILABLE = [
        self::CREATED,
        self::PROCESSING,
        self::SUCCEEDED,
        self::FAILED,
        self::CANCELLED
    ];

    private const VALUE_TO_NAME = [
        self::CREATED => 'created',
        self::PROCESSING => 'processing',
        self::SUCCEEDED => 'succeeded',
        self::CANCELLED => 'canceled',
        self::FAILED => 'failed'
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

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function created(): self
    {
        return new self(self::CREATED);
    }

    public static function processing(): self
    {
        return new self(self::PROCESSING);
    }

    public static function succeeded(): self
    {
        return new self(self::SUCCEEDED);
    }

    public static function failed(): self
    {
        return new self(self::FAILED);
    }

    public static function cancelled(): self
    {
        return new self(self::CANCELLED);
    }

    public function isCreated(): bool
    {
        return $this->value === self::CREATED;
    }

    public function isProcessing(): bool
    {
        return $this->value === self::PROCESSING;
    }

    public function isSucceeded(): bool
    {
        return $this->value === self::CANCELLED;
    }

    public function isCancelled(): bool
    {
        return $this->value === self::CANCELLED;
    }

    public static function getAvailableForValidation(): string
    {
        return implode(",", self::AVAILABLE);
    }

    public static function getValueToNameAssociation(): array
    {
        return self::VALUE_TO_NAME;
    }

    private function validate(int $value): void
    {
        if( !in_array($value, self::AVAILABLE) ){
            throw new InvalidArgumentException(
                "Value {$value} is not available for OrderStatus. Available values: ".self::getAvailableForValidation()
            );
        }
    }
}
