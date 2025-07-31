<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Repository;

use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\ValueObject\RequestDateVO;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\CarbonInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class RequestRepository implements RequestRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager) {}

    public function count(RequestIPVO $ip, RequestRouteVO $route, CarbonInterface $date, string $timeFrame): int
    {
        $date = new RequestDateVO($date->sub($timeFrame)->toAtomString());

        $result = $this->manager->createQueryBuilder()
            ->from(Request::class, 'r')
            ->select('count(r.uuid) as count')
            ->where('r.ip = :ip')
            ->andWhere('r.route = :route')
            ->andWhere('r.date >= :date')
            ->setParameter('ip', $ip)
            ->setParameter('route', $route)
            ->setParameter('date', $date->value)
            ->getQuery()
            ->getSingleResult();

        return $result['count'];
    }

    public function save(Request $request): void
    {
        $this->manager->persist($request);
        $this->manager->flush();
    }
}
