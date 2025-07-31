<?php

namespace App\Tests\codeception\_data\_OM\_Symfony\Application\Test\View;

use App\Application\Test\View\TestFullDataView;

class TestFullDataMother
{
    public static function generate(string $uuid, string $name, int $number): TestFullDataView
    {
        return new TestFullDataView($uuid, $name, $number);
    }
}
