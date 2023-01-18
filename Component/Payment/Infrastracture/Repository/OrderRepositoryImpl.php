<?php

declare(strict_types=1);

namespace Component\Payment\Infrastracture\Repository;

use Common\ValueObject\OrderStatus;
use Common\ValueObject\PaymentProvider;
use Common\ValueObject\Uuid;
use Component\Payment\Domain\Repository\OrderRepository;
use Component\Payment\Infrastracture\Mapper\OrderMapper;
use Component\Payment\Sdk\Exception\OrderNotFoundException;
use Component\Payment\Sdk\Exception\OrderPaymentReceiverNotFoundException;
use Component\Payment\Sdk\Model\OrderRead;
use Component\Payment\Sdk\Model\OrderWrite;
use Illuminate\Support\Facades\DB;

class OrderRepositoryImpl implements OrderRepository
{
    private DB $database;

    private OrderMapper $orderMapper;

    public function __construct(DB $database, OrderMapper $orderMapper)
    {
        $this->database = $database;
        $this->orderMapper = $orderMapper;
    }

    public function create(OrderWrite $orderWrite): OrderRead
    {
        $this->database::table('orders')
            ->insert([
                [
                    'id' => $orderWrite->getId(),
                    'buyer_id' => $orderWrite->getBuyerId(),
                    'product_id' => $orderWrite->getProductId(),
                    'payment_provider_order_id' => $orderWrite->getPaymentProviderOrderId(),
                    'payment_provider_id' => $orderWrite->getPaymentProvider()->getValue(),
                    'amount' => $orderWrite->getPrice()->getAmount(),
                    'currency' => $orderWrite->getPrice()->getCurrency(),
                    'order_status_id' => $orderWrite->getOrderStatus()->getValue(),
                ]
            ]);

        return $this->findByPaymentProviderOrderId($orderWrite->getPaymentProviderOrderId());
    }

    public function getPaymentReceiverPaymentProviderAccountId(Uuid $orderId, PaymentProvider $paymentProvider): string
    {
        $account = $this->database::table('order_payment_recipients')
            ->where('order_payment_recipients.order_id', $orderId)
            ->where('user_payment_provider_accounts.payment_provider_id', $paymentProvider->getValue())
            ->join(
                'user_payment_provider_accounts',
                'user_payment_provider_accounts.user_id',
                '=',
                'order_payment_recipients.user_id'
            )
            ->select('user_payment_provider_accounts.account_id')
            ->first();

        if ($account === null) {
            throw new OrderPaymentReceiverNotFoundException($orderId);
        }

        return $account->account_id;
    }

    public function findByPaymentProviderOrderId(string $paymentProviderOrderId): OrderRead
    {
        $order = $this->database::table('orders')
            ->where('payment_provider_order_id', $paymentProviderOrderId)
            ->first();

        if ($order === null) {
            throw new OrderNotFoundException($paymentProviderOrderId);
        }

        return $this->orderMapper->mapToOrderRead($order);
    }

    public function getOrderStatusByPaymentProviderOrderId(string $paymentProviderOrderId): OrderStatus
    {
        $order = $this->database::table('orders')
            ->where('payment_provider_order_id', $paymentProviderOrderId)
            ->select('order_status')
            ->first();

        if ($order === null) {
            throw new OrderNotFoundException($paymentProviderOrderId);
        }

        return new OrderStatus($order->order_status_id);
    }

    public function updateStatusByPaymentProviderOrderId(string $paymentProviderOrderId, OrderStatus $orderStatus): OrderRead
    {
        $this->database::table('orders')
            ->where('payment_provider_order_id', $paymentProviderOrderId)
            ->update([
                'order_status' => $orderStatus->getValue()
            ]);

        return $this->findByPaymentProviderOrderId($paymentProviderOrderId);
    }
}
