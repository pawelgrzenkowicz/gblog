<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Console;

use App\Application\Application;
use Symfony\Component\Console\Command\Command as BaseCommand;

abstract class Command extends BaseCommand
{
    public function __construct(protected readonly Application $application)
    {
        parent::__construct();
    }
}
