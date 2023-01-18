<?php

namespace Component\Payment\Domain\Strategy\CreateOrder;

use Common\ValueObject\Uuid;
use Component\Payment\Domain\Repository\OrderRepository;
use Component\Payment\Domain\Repository\ProductRepository;
use Component\Payment\Sdk\Contract\CreateOrderContract;
use Component\Payment\Sdk\Mapper\OrderStatusMapper;
use Component\Payment\Sdk\Model\PaymentData;
use Component\Payment\Sdk\Stripe\Lib\Stripe;

class CreateOrderOnStripeSide
{
    private ProductRepository $productRepository;
    private OrderStatusMapper $orderStatusMapper;
    private Stripe $stripe;

    public function __construct(ProductRepository $productRepository, OrderStatusMapper $orderStatusMapper, Stripe $stripe)
    {
        $this->productRepository = $productRepository;
        $this->orderStatusMapper = $orderStatusMapper;
        $this->stripe = $stripe;
    }

    public function handle(CreateOrderContract $contract): PaymentData
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

        return new PaymentData(
            $paymentIntent->getIntentId(),
            $this->orderStatusMapper->mapStripeStatusToOrderStatus($paymentIntent->getStatus())
        );
    }
}
