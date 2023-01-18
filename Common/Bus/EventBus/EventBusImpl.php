<?php

declare(strict_types=1);

namespace Common\Bus\EventBus;

use Common\Event\Event;
use Illuminate\Events\Dispatcher;

class EventBusImpl implements EventBus
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(Event $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
