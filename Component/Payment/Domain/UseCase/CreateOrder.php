<?php

declare(strict_types=1);

namespace Component\Payment\Domain\UseCase;

use Common\Exception\ApiException;
use Common\Exception\InvalidArgumentException;
use Common\ValueObject\OrderStatus;
use Common\ValueObject\Uuid;
use Component\Payment\Domain\Repository\OrderRepository;
use Component\Payment\Domain\Repository\ProductRepository;
use Component\Payment\Domain\Strategy\CreateOrder\CreateOrderOnStripeSide;
use Component\Payment\Sdk\Contract\CreateOrderContract;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\OrderWrite;
use Component\Payment\Sdk\Model\PaymentData;

final class CreateOrder
{
    private OrderRepository $orderRepository;
    private CreateOrderOnStripeSide $createOrderWithStripe;
    private ProductRepository $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        CreateOrderOnStripeSide $createOrderWithStripe,
        ProductRepository $productRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->createOrderWithStripe = $createOrderWithStripe;
        $this->productRepository = $productRepository;
    }

    public function handle(CreateOrderContract $contract, Uuid $userId): OrderRead
    {
        $paymentData = $this->createOrderOnPaymentProviderSide($contract);

        if (!$paymentData->getOrderStatus()->isCreated()) {
            throw new ApiException("Payment intent was created with unexpected status: {$paymentData->getOrderStatus()->getValue()}");
        }

        return $this->orderRepository->create(new OrderWrite(
            $userId,
            $contract->getProductId(),
            $paymentData->getPaymentProviderOrderId(),
            $contract->getPaymentProvider(),
            OrderStatus::created(),
            $this->productRepository->getPrice($contract->getProductId())
        ));
    }

    private function createOrderOnPaymentProviderSide(CreateOrderContract $contract): PaymentData
    {
        if ($contract->getPaymentProvider()->isStripe()) {
            return $this->createOrderWithStripe->handle($contract);
        }
        throw new InvalidArgumentException("Creating orders for this provider is not handled");
    }
}
