<?php

namespace App\Tests\codeception\functional\Infrastructure\Test\Repository;

use App\Infrastructure\Test\Repository\TestRepository;
use App\Tests\codeception\FunctionalTester;
use Ramsey\Uuid\Uuid;

class TestRepositoryCest
{
    private const string EXIST_UUID = 'a931001e-56ff-4752-b3db-f7ed3544c385';

    private bool $initialized = false;

    public function _before(FunctionalTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('tests');
        $I->loadSqlFile('dev.tests.tests_insert.sql');

        $this->initialized = true;
    }

    public function testShouldGetTestByUuid(FunctionalTester $I): void
    {
        // When
        /** @var TestRepository $repo */
        $repo = $I->getClass(TestRepository::class);
        $test = $repo->byUuid(Uuid::fromString(self::EXIST_UUID));

        // Then
        $I->assertNotEmpty($test);
        $I->assertSame('cos', $test->name()->__toString());
        $I->assertSame(12, $test->number()->toInteger());
    }

    public function testShouldReturnNullWhenTestNotFound(FunctionalTester $I): void
    {
        // Given
        /** @var TestRepository $repo */
        $repo = $I->getClass(TestRepository::class);

        // When
        $test = $repo->byUuid(Uuid::fromString('5d27ae18-27a7-4137-b386-56800f8be9c2'));

        // Then
        $I->assertNull($test);
    }
}
