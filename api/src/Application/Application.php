<?php

declare(strict_types=1);

namespace App\Application;

interface Application
{
    public function ask(object $query);

    public function execute(object $command);
}
