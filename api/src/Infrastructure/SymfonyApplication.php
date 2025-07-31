<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Application;
use App\Infrastructure\Symfony\Messenger\SimpleMessageBusInterface;

final readonly class SymfonyApplication implements Application
{
    public function __construct(
        private SimpleMessageBusInterface $commands,
        private SimpleMessageBusInterface $queries,
    ) {}

    public function ask(object $query)
    {
        return $this->queries->dispatch($query);
    }

    public function execute(object $command)
    {
        return $this->commands->dispatch($command);
    }
}
