<?php

declare(strict_types=1);

namespace Component\Auth\Sdk\Model;

use Common\ValueObject\Uuid;

class UserRead
{
    private Uuid $id;

    private string $name;

    private string $email;

    public function __construct(Uuid $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
