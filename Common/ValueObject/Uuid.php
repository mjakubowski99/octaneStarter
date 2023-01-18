<?php

declare(strict_types=1);

namespace Common\ValueObject;

use Common\Exception\InvalidArgumentException;

class Uuid
{
    private string $uuid;

    public function __construct(?string $uuid = null)
    {
        if ($uuid !== null) {
            $this->uuid = $uuid;
        } else {
            $this->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        }
        $this->validate();
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function equals(Uuid $uuid): bool
    {
        return $this->uuid === $uuid->getUuid();
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    private function validate(): void
    {
        if (!\Ramsey\Uuid\Uuid::isValid($this->uuid)) {
            throw new InvalidArgumentException('UUID_INVALID');
        }
    }
}
