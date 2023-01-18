<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Strategy\CreateOrder;

use Component\Payment\Sdk\Contract\CreateOrderContract;
use Component\Payment\Sdk\Model\PaymentData;

interface CreateOrderOnPaymentProviderSide
{
    public function handle(CreateOrderContract $contract): PaymentData;
}
