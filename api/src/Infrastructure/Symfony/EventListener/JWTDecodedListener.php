<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventListener;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\User\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTDecodedListener
{
    private RequestStack $requestStack;

    private UserRepositoryInterface $userRepository;

    public function __construct(RequestStack $requestStack, UserRepositoryInterface $userRepository)
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
    }

    public function __invoke(JWTDecodedEvent $event)
    {

//        dump('xxx');
//        exit;
//        dump($this->requestStack->getCurrentRequest()->getClientIp());
//        dump('xx');
//        dump($event);
//        exit;
//        dump($event);

//        $request = $this->requestStack->getCurrentRequest();
//        dump($request->getClientIp());

//        $payload = $event->getPayload();
//        dump('JWTDecodedListener');
//        dump($payload);

//        $user = $this->userRepository->byEmail(new EmailVO($payload['username']));

//        $payload['userDomain'] = $user;
//        $payload['userDomain'] = '1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111';
//        $user->update(['password' => 'lol123']);

//        if (!isset($payload['ip']) || $payload['ip'] !== $request->getClientIp()) {
//            $event->markAsInvalid();
//        }
//        dd($event);
//        exit;
//        $event->setPayload($payload);
    }
}
