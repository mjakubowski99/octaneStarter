<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Repository;

use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\Price;

interface ProductRepository
{
    public function getPrice(Uuid $productId): Price;

    public function hasOwner(Uuid $productId): bool;

    public function getOwnerPaymentProviderAccountId(Uuid $productId, PaymentProvider $paymentProvider): string;
}
