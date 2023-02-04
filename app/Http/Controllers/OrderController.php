<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Common\Http\Controller\AbstractController;
use Component\Auth\Sdk\AuthFacade;
use Component\Payment\Infrastracture\Http\Request\Stripe\CreatePaymentIntentRequest;
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
}

