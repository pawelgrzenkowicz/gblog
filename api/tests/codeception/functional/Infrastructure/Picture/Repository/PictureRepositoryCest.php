<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\Picture\Repository;

use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Infrastructure\Picture\Repository\PictureRepository;
use App\Tests\codeception\ApiTester;
use App\Tests\codeception\FunctionalTester;

class PictureRepositoryCest
{
    private const string EXIST_SOURCE = 'article/content/2024/TEST-small.jpg';
    private const string EXIST_UUID = '36aadce6-5154-4fdb-8cf8-e623450f3285';
    private const string NON_EXIST_SOURCE = 'article/content/2024/TEST_not_exist.jpg';

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('pictures');
        $I->clearDb('users');

        $I->loadSqlFile('dev.pictures.pictures_insert.sql');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    public function testShouldGetPictureByUuid(FunctionalTester $I): void
    {
        // When
        /** @var PictureRepository $repo */
        $repo = $I->getClass(PictureRepository::class);
        $picture = $repo->bySource(new PictureSourceVO(self::EXIST_SOURCE));

        // Then
        $I->assertNotEmpty($picture);
        $I->assertSame(self::EXIST_UUID, $picture->uuid->toString());
        $I->assertSame('jakiś TEST alt', $picture->alt()->__toString(), );
        $I->assertSame(self::EXIST_SOURCE, $picture->source()->__toString());
        $I->assertSame('jpg', $picture->extension()->value);
    }

    public function testShouldReturnNullWhenPictureNotFound(FunctionalTester $I): void
    {
        // When
        /** @var PictureRepository $repo */
        $repo = $I->getClass(PictureRepository::class);
        $picture = $repo->bySource(new PictureSourceVO(self::NON_EXIST_SOURCE));

        // Then
        $I->assertNull($picture);
    }

    # DELETE #

    public function testShouldDeletePicture(FunctionalTester $I): void
    {
        // When
        /** @var PictureRepository $repo */
        $repo = $I->getClass(PictureRepository::class);
        $picture = $repo->bySource(new PictureSourceVO(self::EXIST_SOURCE));

        $repo->delete($picture);

        $I->dontSeeInDatabase('pictures', ['source' => self::EXIST_SOURCE]);

        $entries = $I->grabEntriesFromDatabase('pictures', ['source' => self::EXIST_SOURCE]);

        // Then
        $I->assertEmpty($entries);
    }
}
