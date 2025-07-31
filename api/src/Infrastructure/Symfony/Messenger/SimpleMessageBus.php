<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Messenger;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SimpleMessageBus implements SimpleMessageBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $bus)
    {
        $this->messageBus = $bus;
    }

    public function dispatch(object $message)
    {
        return $this->handle($message);
    }
}
