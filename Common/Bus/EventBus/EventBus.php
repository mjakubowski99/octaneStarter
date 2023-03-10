<?php

declare(strict_types=1);

namespace Common\Bus\EventBus;

use Common\Event\Event;

interface EventBus
{
    public function dispatch(Event $event): void;
}
