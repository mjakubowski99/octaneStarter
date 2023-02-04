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
use Component\Payment\Sdk\Stripe\Intent\StripePaymentIntent;
use Component\Payment\Sdk\Stripe\Lib\Stripe;

final class CreateOrderWithStripe
{
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;
    private Stripe $stripe;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        Stripe $stripe
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->stripe = $stripe;
    }

    public function handle(CreateOrderContract $contract, Uuid $userId): StripePaymentIntent
    {
        $paymentIntent = $this->createOrderOnStripeSide($contract);

        $this->orderRepository->create(new OrderWrite(
            $userId,
            $contract->getProductId(),
            $paymentIntent->getIntentId(),
            $contract->getPaymentProvider(),
            OrderStatus::created(),
            $this->productRepository->getPrice($contract->getProductId())
        ));

        return $paymentIntent;
    }

    private function createOrderOnStripeSide(CreateOrderContract $contract): StripePaymentIntent
    {
        $price = $this->productRepository->getPrice($contract->getProductId());

        $opts = [
            'idempotency_key' => (new Uuid())->getUuid()
        ];

        if ($this->productRepository->hasOwner($contract->getProductId())) {
            $opts['connected_account_id'] = "";
        }

        $paymentIntent = $this->stripe->createPaymentIntent([
            'amount' => $price->getAmount(),
            'currency' => $price->getCurrency()->getValue(),
            'payment_method_types' => $contract->getPaymentMethods()
        ], $opts);

        if (!$paymentIntent->getStatus()->isRequiresPaymentMethod()) {
            throw new ApiException("Payment intent was created with unexpected status: {$paymentIntent->getStatus()->getValue()}");
        }

        return $paymentIntent;
    }
}
