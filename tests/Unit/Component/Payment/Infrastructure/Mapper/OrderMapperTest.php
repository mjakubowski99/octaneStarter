<?php

declare(strict_types=1);

namespace Tests\Unit\Component\Payment\Infrastructure\Mapper;

use Common\Exception\InvalidArgumentException;
use Common\ValueObject\Currency;
use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Infrastracture\Mapper\OrderMapper;
use Component\Payment\Sdk\Model\OrderRead;
use Tests\TestCase;

class OrderMapperTest extends TestCase
{
    public function test_mapToOrderRead_ShouldThrowErrorExceptionWhenSomeOfRequiredArrayKeyIsUndefined(): void
    {
        $mapper = new OrderMapper();

        $this->expectException(\ErrorException::class);

        $mapper->mapToOrderRead([]);
    }

    public function test_mapToOrderRead_ShouldThrowInvalidArgumentExceptionWhenPaymentProviderDoesNotExists(): void
    {
        $mapper = new OrderMapper();

        $this->expectException(InvalidArgumentException::class);

        $mapper->mapToOrderRead([
            'id' => (string) new Uuid(),
            'buyer_id' => (string) new Uuid(),
            'product_id' => (string) new Uuid(),
            'payment_provider_order_id' => 1,
            'payment_provider' => -1
        ]);
    }

    public function test_mapToOrderRead_ShouldThrowInvalidArgumentExceptionWhenOrderStatusDoesNotExists(): void
    {
        $mapper = new OrderMapper();

        $this->expectException(InvalidArgumentException::class);

        $mapper->mapToOrderRead([
            'id' => (string) new Uuid(),
            'buyer_id' => (string) new Uuid(),
            'product_id' => (string) new Uuid(),
            'payment_provider_order_id' => 1,
            'payment_provider' => PaymentProvider::stripe()->getValue(),
            'order_status' => -1
        ]);
    }

    public function test_mapToOrderRead_ShouldReturnOrderReadModel_WhenAllParametersDefinedInArrayAndEveryValueObjectIsValid(): void
    {
        $mapper = new OrderMapper();

        $orderRead = $mapper->mapToOrderRead([
            'id' => (string) new Uuid(),
            'buyer_id' => (string) new Uuid(),
            'product_id' => (string) new Uuid(),
            'payment_provider_order_id' => "some_order_id_from_payment_provider_side",
            'payment_provider' => PaymentProvider::stripe()->getValue(),
            'order_status' => OrderStatus::succeeded()->getValue(),
            'amount' => 100,
            'currency' => Currency::pln()->getValue()
        ]);

        $this->assertInstanceOf(OrderRead::class, $orderRead);
    }
}
