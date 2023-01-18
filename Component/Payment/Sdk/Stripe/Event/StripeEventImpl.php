<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Stripe\Event;

use Common\Exception\InvalidArgumentException;
use Component\Payment\Sdk\Stripe\Intent\StripePaymentIntent;
use Component\Payment\Sdk\Stripe\ValueObject\EventType;
use Component\Payment\Sdk\Stripe\ValueObject\Status;
use Stripe\Account;
use Stripe\Event;
use Stripe\StripeObject;

class StripeEventImpl implements StripeEvent
{
    private EventType $eventType;

    private StripeObject $data;

    private bool $isConnectEvent;

    public function __construct(Event $event, bool $isConnectEvent)
    {
        $this->eventType = new EventType($event->type);
        $this->data = $event->data->object;
        $this->isConnectEvent = $isConnectEvent;
    }

    public function getType(): EventType
    {
        return $this->eventType;
    }

    public function isConnectEvent(): bool
    {
        return $this->isConnectEvent;
    }

    public function getPaymentIntentObject(): StripePaymentIntent
    {
        if (!$this->eventType->isPaymentIntent()) {
            throw new InvalidArgumentException("PaymentIntentObject is not associated with event type: {$this->eventType->getValue()}");
        }

        if ($this->data->on_behalf_of instanceof Account) {
            $accountId = $this->data->on_behalf_of->id;
        } else {
            $accountId = $this->data->on_behalf_of;
        }

        return new StripePaymentIntent(
            $this->data->id,
            new Status($this->data->status),
            $accountId
        );
    }
}
