<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Entities;

use Common\ValueObject\Currency;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\Price;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids, HasFactory;

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getPrice(): Price
    {
        return new Price(
            $this->amount,
            new Currency($this->currency)
        );
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
