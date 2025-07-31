<?php

namespace App\Tests\codeception\functional\Infrastructure\Test\Reader;

use App\Infrastructure\Test\Reader\TestFullDataSqlReader;
use App\Tests\codeception\_data\_OM\_Symfony\Application\Test\View\TestFullDataMother;
use App\Tests\codeception\FunctionalTester;
use Ramsey\Uuid\Uuid;

class TestFullDataSqlReaderCest
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

    public function testShouldGetByUuid(FunctionalTester $I): void
    {
        // Given
        $expected = TestFullDataMother::generate(self::EXIST_UUID, 'cos', 12);

        // When
        /** @var TestFullDataSqlReader $reader */
        $reader = $I->getClass(TestFullDataSqlReader::class);
        $test = $reader->byUuid(Uuid::fromString(self::EXIST_UUID));

        // Then
        $I->assertEquals($expected, $test);
    }

    public function testShouldReturnNullWhenTestNotFound(FunctionalTester $I): void
    {
        // When
        /** @var TestFullDataSqlReader $reader */
        $reader = $I->getClass(TestFullDataSqlReader::class);
        $test = $reader->byUuid(Uuid::fromString('5d27ae18-27a7-4137-b386-56800f8be9c2'));

        // Then
        $I->assertNull($test);
    }
}
