<?php

declare(strict_types=1);

namespace Component\Payment\Sdk\Event;

use Common\Event\Event;
use Component\Payment\Sdk\Model\OrderRead;

class OrderSucceeded implements Event
{
    private OrderRead $orderRead;

    public function __construct(OrderRead $orderRead)
    {
        $this->orderRead = $orderRead;
    }

    public function getOrderRead(): OrderRead
    {
        return $this->orderRead;
    }
}
