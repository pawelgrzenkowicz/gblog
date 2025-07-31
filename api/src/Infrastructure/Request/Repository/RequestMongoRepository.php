<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Repository;

use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\ValueObject\RequestDateVO;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Doctrine\ODM\MongoDB\DocumentManager;

final readonly class RequestMongoRepository
{
    public function __construct(private DocumentManager $documentManager) {}

    public function count(RequestIPVO $ip, RequestRouteVO $route, RequestDateVO $date, string $timeFrame): int
    {
        $results = $this->documentManager->createQueryBuilder(Request::class)
            ->field('ip')->equals($ip)
            ->field('route')->equals($route)
            ->field('date')->gte(new RequestDateVO($date->value->sub($timeFrame)->toAtomString()))
            ->getQuery()
            ->execute();

        return count($results->toArray());
    }

    public function save(Request $request): void
    {
        $this->documentManager->persist($request);
        $this->documentManager->flush();
    }
}
