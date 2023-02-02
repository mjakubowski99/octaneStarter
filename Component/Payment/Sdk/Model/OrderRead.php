<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Model;

use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;

final class OrderRead
{
    private Uuid $id;

    private Uuid $buyerId;

    private Uuid $productId;

    private string $paymentProviderOrderId;

    private PaymentProvider $paymentProvider;

    private OrderStatus $orderStatus;

    private Price $price;

    public function __construct(
        Uuid $id,
        Uuid $buyerId,
        Uuid $productId,
        string $paymentProviderOrderId,
        PaymentProvider $paymentProvider,
        OrderStatus $orderStatus,
        Price $price
    ) {
        $this->id = $id;
        $this->buyerId = $buyerId;
        $this->productId = $productId;
        $this->paymentProviderOrderId = $paymentProviderOrderId;
        $this->paymentProvider = $paymentProvider;
        $this->orderStatus = $orderStatus;
        $this->price = $price;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getBuyerId(): Uuid
    {
        return $this->buyerId;
    }

    public function getProductId(): Uuid
    {
        return $this->productId;
    }

    public function getPaymentProviderOrderId(): string
    {
        return $this->paymentProviderOrderId;
    }

    public function getPaymentProvider(): PaymentProvider
    {
        return $this->paymentProvider;
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
