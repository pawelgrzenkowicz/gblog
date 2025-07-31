<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\_Symfony\Component\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class EnvelopeMother
{
    public static function forMessage(object $message): Envelope
    {
        return new Envelope($message);
    }

    public static function randomlyHandled(object $message, mixed $result): Envelope
    {
        $stamp = new HandledStamp($result, uniqid());

        return self::forMessage($message)->with($stamp);
    }
}
