<?php

declare(strict_types=1);

namespace Component\Product\Sdk\Model;

use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\Price;

class Product
{
    public Uuid $id;

    public string $name;

    public string $description;

    public Price $price;

    public string $image;

    public function __construct(
        Uuid $id,
        string $name,
        string $description,
        Price $price,
        string $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getUuid(),
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image,
            'amount' => $this->price->getAmount(),
            'currency' => $this->price->getCurrency()
        ];
    }
}
