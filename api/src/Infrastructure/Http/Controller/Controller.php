<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Application;

abstract class Controller
{
    final public function __construct(protected readonly Application $application)
    {
    }
}
