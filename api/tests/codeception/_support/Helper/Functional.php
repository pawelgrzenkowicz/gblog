<?php

declare(strict_types=1);

namespace App\Tests\codeception\_support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;

class Functional extends \Codeception\Module
{
    public function getModule(string $name): Module
    {
        return parent::getModule($name);
    }

    public function getModules(): array
    {
        return parent::getModules();
    }

    public function getClass(string $id): ?object
    {
        return parent::getModule('Symfony')->_getContainer()->get($id);
    }
}
