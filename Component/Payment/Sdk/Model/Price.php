<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Model;

use Common\ValueObject\Currency;

class Price
{
    private int $amount;

    private Currency $currency;

    public function __construct(int $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function equals(Price $price): bool
    {
        return ($this->getAmount() === $price->getAmount())
            && $this->getCurrency()->equals($price->getCurrency());
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
