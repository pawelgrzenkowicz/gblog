<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\EmailVO;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailVOTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $emailVO = $this->createInstanceUnderTest($email = 'test@test.test');

        // Then
        $this->assertSame($emailVO->__toString(), $email);
    }

    public function testShouldThrowExceptionWhenEmailIsNotValid(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest('wrong_email');
    }

    private function createInstanceUnderTest(string $value): EmailVO
    {
        return new EmailVO($value);
    }
}
