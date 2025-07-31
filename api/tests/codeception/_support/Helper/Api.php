<?php

declare(strict_types=1);

namespace App\Tests\codeception\_support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;

class Api extends Module
{
    protected function tryToLogin($userLogin)
    {
        $I = $this;

        $I->wantTo('login into api');
        $I->amGoingTo('try to log to API using login and password');
        $I->sendPOST('/system/login', ['login' => $userLogin, 'password' => self::getPassword($userLogin)]);

        // ...some other checking if user was correctly logged in ...
    }
}
