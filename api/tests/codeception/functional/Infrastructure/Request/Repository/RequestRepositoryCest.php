<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\Request\Repository;

use App\Infrastructure\Request\Repository\RequestRepository;
use App\Infrastructure\Request\Repository\RequestRepositoryInterface;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use App\Tests\codeception\ApiTester;
use App\Tests\codeception\FunctionalTester;
use Carbon\Carbon;
use Codeception\Attribute\DataProvider;
use Codeception\Example;

class RequestRepositoryCest
{
    private const string EXIST_IP = '127.0.0.1';

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('requests');
        $I->loadSqlFile('dev.requests.requests_insert.sql');

        $this->initialized = true;
    }

    private function provideRequestsCountParams(): array
    {
        return [
            [
                'ip' => self::EXIST_IP,
                'route' => 'user.create',
                'date' => '2024-01-02T15:00:00+00:00',
                'timeFrame' => '1 day',
                'count' => 0,
            ],
            [
                'ip' => self::EXIST_IP,
                'route' => 'user.create',
                'date' => '2024-01-02T12:00:00+00:00',
                'timeFrame' => '1 day',
                'count' => 3,
            ],
        ];
    }

    #[DataProvider('provideRequestsCountParams')]
    public function testShouldCountRequests(FunctionalTester $I, Example $example): void
    {
        // When
        /** @var RequestRepositoryInterface $repo */
        $repo = $I->getClass(RequestRepository::class);
        $count = $repo->count(
            new RequestIPVO($example['ip']),
            new RequestRouteVO($example['route']),
            new Carbon($example['date']),
            $example['timeFrame']
        );

        // Then
        $I->assertSame($example['count'], $count);
    }
}
