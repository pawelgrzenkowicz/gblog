<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Messenger;

interface SimpleMessageBusInterface
{
    public function dispatch(object $message);
}
