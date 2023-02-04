<?php

declare(strict_types=1);

namespace Component\Payment\Domain\Service;

use Common\Exception\InvalidArgumentException;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Domain\Repository\OrderRepository;
use Component\Payment\Sdk\Exception\OrderPaymentReceiverNotFoundException;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\PaymentData;
use Component\Payment\Sdk\Model\StripePaymentIntentReadModel;
use Illuminate\Contracts\Config\Repository as Config;

class PaymentServiceImpl implements PaymentService
{
    private Config $config;
    private OrderRepository $orderRepository;

    public function __construct(Config $config, OrderRepository $orderRepository)
    {
        $this->config = $config;
        $this->orderRepository = $orderRepository;
    }

    public function getOrderPaymentReceiverAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string
    {
        return $this->orderRepository->getPaymentReceiverPaymentProviderAccountId($orderId, $paymentProvider);
    }

    public function getPublishableKeyForPaymentProvider(PaymentProvider $paymentProvider)
    {
        if ($paymentProvider->isStripe()) {
            return $this->config->get('services.stripe.publishable_key');
        }
        throw new InvalidArgumentException("This provider: {$paymentProvider} does not have any publishable key defined");
    }

    public function getStripePaymentIntentReadModel(PaymentData $paymentData): StripePaymentIntentReadModel
    {
        return new StripePaymentIntentReadModel(
            $this->getPublishableKeyForPaymentProvider(PaymentProvider::stripe()),
            $paymentData->getClientSecret(),
            $paymentData->getPaymentProviderOrderId(),
            $paymentData->getPaymentReceiverId()
        );
    }
}
