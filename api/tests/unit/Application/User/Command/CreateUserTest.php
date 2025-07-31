<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Command;

use App\Application\User\Command\CreateUser;
use App\Domain\Shared\Enum\Role;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());
        $nickname = uniqid();
        $plainPassword = 'CosCos123!';

        // When
        $actual = new CreateUser($email, $nickname, $plainPassword, Role::FREE_USER);

        // Exception

        // Then
        $this->assertSame($email, $actual->email->__toString());
        $this->assertSame($plainPassword, $actual->plainPassword->__toString());
    }
}
