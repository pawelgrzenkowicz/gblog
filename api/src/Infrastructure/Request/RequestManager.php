<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Infrastructure\Request\Repository\RequestRepositoryInterface;
use Carbon\Carbon;

final readonly class RequestManager implements RequestManagerInterface
{
    public function __construct(
        private GenerateRequestInterface $generateRequest,
        private RequestRepositoryInterface $requestRepository
    ) {}

    public function add(string $ip, string $route, string $date): void
    {
        $this->requestRepository->save($this->generateRequest->generate($ip, $route, $date));
    }

    public function allow(string $ip, string $route, Config $config): bool
    {
        return $config->requestLimit > $this->countRequest($ip, $route, $config);
    }

    public function routeExist(?string $route): ?Config
    {
        /** @var Config $configuration */
        foreach ($this->getConfiguration() as $configuration) {
            if ($configuration->route === $route) {
                return $configuration;
            }
        }

        return null;
    }

    private function countRequest(string $ip, string $route, Config $config): int
    {
        return $this->requestRepository->count(
            $this->generateRequest->ip($ip),
            $this->generateRequest->route($route),
            $this->generateRequest->date((new Carbon())->toAtomString()),
            $config->timeFrame
        );
    }

    private function getConfiguration(): array
    {
        return RequestConfiguration::get();
    }
}
