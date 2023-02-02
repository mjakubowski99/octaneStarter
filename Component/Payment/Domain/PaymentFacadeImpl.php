<?php

declare(strict_types=1);

namespace Component\Payment\Domain;

use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Domain\Service\PaymentService;
use Component\Payment\Domain\UseCase\CreateOrder;
use Component\Payment\Domain\UseCase\ReceiveWebhookNotification;
use Component\Payment\Sdk\Contract\CreateOrderContract;
use Component\Payment\Sdk\Contract\PaymentWebhookContract;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\StripePaymentIntentReadModel;
use Component\Payment\Sdk\PaymentFacade;

class PaymentFacadeImpl implements PaymentFacade
{
    private PaymentService $paymentService;
    private ReceiveWebhookNotification $receiveWebhookNotification;
    private CreateOrder $createOrder;

    public function __construct(
        PaymentService $paymentService,
        ReceiveWebhookNotification $receiveWebhookNotification,
        CreateOrder $createOrder
    ) {
        $this->paymentService = $paymentService;
        $this->receiveWebhookNotification = $receiveWebhookNotification;
        $this->createOrder = $createOrder;
    }

    public function createOrder(CreateOrderContract $contract, Uuid $userId): OrderRead
    {
        return $this->createOrder->handle($contract, $userId);
    }

    public function getOrderPaymentReceiverAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string
    {
        return $this->paymentService->getOrderPaymentReceiverAccountId($orderId, $paymentProvider);
    }

    public function getStripePaymentIntentReadModel(OrderRead $orderRead): StripePaymentIntentReadModel
    {
        return $this->paymentService->getStripePaymentIntentReadModel($orderRead);
    }

    public function receiveWebhookNotification(PaymentWebhookContract $contract): void
    {
        $this->receiveWebhookNotification->handle($contract);
    }
}
