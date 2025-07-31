<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\User\TokenDecoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

readonly class TokenDecoder implements TokenDecoderInterface
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private JWTTokenManagerInterface $JWTTokenManager
    ) {}

    public function decodeEmail(): ?EmailVO
    {
        $token = $this->decode();
        return $token ? new EmailVO($token['username']) : null;
    }

    private function decode(): array|false
    {
        return $this->JWTTokenManager->decode($this->tokenStorage->getToken());
    }
}
