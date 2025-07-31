<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Command;

use App\Application\User\Command\CreateUser;
use App\Application\User\Command\EditUserPassword;
use App\Domain\Shared\Enum\Role;
use PHPUnit\Framework\TestCase;

class EditUserPasswordTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());
        $nickname = uniqid();
        $oldPlainPassword = 'OldCosCos123!';
        $newPlainPassword = 'CosCos123!';

        // When
        $actual = new EditUserPassword($oldPlainPassword, $newPlainPassword);

        // Exception

        // Then
        $this->assertSame($oldPlainPassword, $actual->oldPassword->__toString());
        $this->assertSame($newPlainPassword, $actual->newPlainPassword->__toString());
    }
}
