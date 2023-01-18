<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Contract;

use Common\ValueObject\PaymentMethod;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;

interface CreateOrderContract
{
    public function getProductId(): Uuid;

    public function getPaymentProvider(): PaymentProvider;

    /** @return PaymentMethod[] */
    public function getPaymentMethods(): array;
}
