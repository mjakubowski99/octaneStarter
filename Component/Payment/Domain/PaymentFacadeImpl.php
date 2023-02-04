<?php

declare(strict_types=1);

namespace Component\Payment\Domain;

use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Domain\Service\PaymentService;
use Component\Payment\Domain\UseCase\CreateOrderWithStripe;
use Component\Payment\Domain\UseCase\ReceiveWebhookNotification;
use Component\Payment\Sdk\Contract\CreateOrderContract;
use Component\Payment\Sdk\Contract\PaymentWebhookContract;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\PaymentData;
use Component\Payment\Sdk\Model\StripePaymentIntentReadModel;
use Component\Payment\Sdk\PaymentFacade;
use Component\Payment\Sdk\Stripe\Intent\StripePaymentIntent;

class PaymentFacadeImpl implements PaymentFacade
{
    private PaymentService $paymentService;
    private ReceiveWebhookNotification $receiveWebhookNotification;
    private CreateOrderWithStripe $createOrderWithStripe;

    public function __construct(
        PaymentService $paymentService,
        ReceiveWebhookNotification $receiveWebhookNotification,
        CreateOrderWithStripe $createOrderWithStripe
    ) {
        $this->paymentService = $paymentService;
        $this->receiveWebhookNotification = $receiveWebhookNotification;
        $this->createOrderWithStripe = $createOrderWithStripe;
    }

    public function createOrderWithStripe(CreateOrderContract $contract, Uuid $userId): StripePaymentIntent
    {
        return $this->createOrderWithStripe->handle($contract, $userId);
    }

    public function getOrderPaymentReceiverAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string
    {
        return $this->paymentService->getOrderPaymentReceiverAccountId($orderId, $paymentProvider);
    }

    public function receiveWebhookNotification(PaymentWebhookContract $contract): void
    {
        $this->receiveWebhookNotification->handle($contract);
    }
}
