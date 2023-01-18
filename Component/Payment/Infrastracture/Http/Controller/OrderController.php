<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Http\Controller;

use Common\Http\Controller\AbstractController;
use Common\ValueObject\PaymentProvider;
use Component\Auth\Sdk\AuthFacade;
use Component\Payment\Infrastracture\Http\Request\Stripe\CreatePaymentIntentRequest;
use Component\Payment\Infrastracture\Http\Request\Stripe\StripeWebhookNotificationRequest;
use Component\Payment\Sdk\PaymentFacade;
use Illuminate\Http\JsonResponse;

class OrderController extends AbstractController
{
    private AuthFacade $authFacade;
    private PaymentFacade $paymentFacade;

    public function __construct(AuthFacade $authFacade, PaymentFacade $paymentFacade)
    {
        $this->authFacade = $authFacade;
        $this->paymentFacade = $paymentFacade;
    }

    public function createWithStripe(CreatePaymentIntentRequest $request): JsonResponse
    {
        $orderRead = $this->paymentFacade->createOrder(
            $request,
            $this->authFacade->current()->getId()
        );

        return new JsonResponse(
            $this->paymentFacade->getStripePaymentIntentReadModel(
                $orderRead
            )->toArray()
        );
    }

    public function receiveStripeWebhookNotification(StripeWebhookNotificationRequest $request): JsonResponse
    {
        $this->paymentFacade->receiveWebhookNotification($request);

        return new JsonResponse(null, 200);
    }
}
