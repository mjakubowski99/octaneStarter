<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Http\Controller;

use Common\Http\Controller\AbstractController;
use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Auth\Sdk\AuthFacade;
use Component\Payment\Domain\UseCase\UpdateOrderStatus;
use Component\Payment\Infrastracture\Http\Request\Stripe\CreatePaymentIntentRequest;
use Component\Payment\Infrastracture\Http\Request\Stripe\StripeWebhookNotificationRequest;
use Component\Payment\Sdk\PaymentFacade;
use Illuminate\Http\JsonResponse;

class OrderController extends AbstractController
{
    private AuthFacade $authFacade;
    private PaymentFacade $paymentFacade;
    private UpdateOrderStatus $updateOrderStatus;

    public function __construct(AuthFacade $authFacade, PaymentFacade $paymentFacade, UpdateOrderStatus $updateOrderStatus)
    {
        $this->authFacade = $authFacade;
        $this->paymentFacade = $paymentFacade;
        $this->updateOrderStatus = $updateOrderStatus;
    }

    public function createWithStripe(CreatePaymentIntentRequest $request): JsonResponse
    {
        $paymentIntent = $this->paymentFacade->createOrderWithStripe(
            $request,
            $this->authFacade->current()->getId()
        );

        return new JsonResponse([
            'client_secret' => $paymentIntent->getClientSecret(),
            'publishable_key' => $paymentIntent->getPublishableKey(),
            'payment_intent_id' => $paymentIntent->getIntentId(),
            'connected_account_id' => $paymentIntent->hasPaymentReceiver() ? $paymentIntent->getPaymentReceiverId() : null
        ]);
    }

    public function receiveStripeWebhookNotification(StripeWebhookNotificationRequest $request): JsonResponse
    {
        $this->paymentFacade->receiveWebhookNotification($request);

        return new JsonResponse(null, 200);
    }

    public function emulateStripeWebhookNotification(): JsonResponse
    {
        $this->updateOrderStatus->handle(
            request()->input('payment_intent_id'),
            OrderStatus::succeeded(),
            PaymentProvider::stripe()
        );

        return new JsonResponse(null, 200);
    }
}
