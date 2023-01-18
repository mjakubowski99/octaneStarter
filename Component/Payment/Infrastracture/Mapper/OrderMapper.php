<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Mapper;

use Common\ValueObject\Currency;
use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\Price;

final class OrderMapper
{
    public function mapToOrderRead(\stdClass $data): OrderRead
    {
        return new OrderRead(
            Uuid::fromString($data->id),
            new Uuid($data->buyer_id),
            new Uuid($data->product_id),
            $data->payment_provider_order_id,
            new PaymentProvider($data->payment_provider_id),
            new OrderStatus($data->order_status_id),
            new Price(
                $data->amount,
                new Currency($data->currency)
            )
        );
    }
}
