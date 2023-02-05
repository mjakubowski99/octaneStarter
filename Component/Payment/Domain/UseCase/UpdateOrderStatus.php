<?php

declare(strict_types=1);

namespace Component\Payment\Domain\UseCase;

use Common\Bus\EventBus\EventBus;
use Common\Exception\ApiException;
use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Component\Payment\Domain\Repository\OrderRepository;
use Component\Payment\Sdk\Event\OrderSucceeded;

final class UpdateOrderStatus
{
    private OrderRepository $orderRepository;
    private EventBus $eventBus;

    public function __construct(OrderRepository $orderRepository, EventBus $eventBus)
    {
        $this->orderRepository = $orderRepository;
        $this->eventBus = $eventBus;
    }

    public function handle(string $paymentProviderOrderId, OrderStatus $orderStatus, PaymentProvider $paymentProvider): void
    {
        $currentStatus = $this->orderRepository->getOrderStatusByPaymentProviderOrderId($paymentProviderOrderId);

        if ($currentStatus->isCreated() && $orderStatus->isProcessing()) {
            $this->orderRepository->updateStatusByPaymentProviderOrderId($paymentProviderOrderId, $orderStatus);
        } elseif (($currentStatus->isProcessing() || $currentStatus->isCreated()) && $orderStatus->isSucceeded()) {
            $this->orderRepository->updateStatusByPaymentProviderOrderId($paymentProviderOrderId, $orderStatus);

            $this->eventBus->dispatch(
                new OrderSucceeded($this->orderRepository->findByPaymentProviderOrderId($paymentProviderOrderId))
            );
        } else {
            throw new ApiException("Unhandled status update from: {$currentStatus->getValue()} to {$orderStatus->getValue()}");
        }
    }
}
