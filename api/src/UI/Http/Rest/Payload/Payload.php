<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract readonly class Payload
{
    final public function __construct(public array $payload)
    {
    }

    final public function validate(ValidatorInterface $validator): array
    {
//        dump($this->payload);
//        dump('xxx');
//        dump($this->payload);
//        dump(static::getConstraints());
        $violations = $validator->validate(
            $this->payload,
            new Collection(fields: static::getConstraints()),
//            new Collection(fields: static::getConstraints($this->payload)),
        );

//        dump('xxx');

        $propertyAccessor = new PropertyAccessor();

        $errors1 = $errors2 = [];

        foreach ($violations as $violation) {
//            dump($violation);
            $path = $violation->getPropertyPath();

            $errors1[$path] = $errors1[$path] ?? [];

            $errors1[$path][] = $violation->getMessage();
        }

        foreach ($errors1 as $path => $errors) {
            $propertyAccessor->setValue($errors2, $path, $errors);
        }

//        dump($errors2);

        return $errors2;
    }

    abstract protected static function getConstraints(): array;
//    abstract protected static function getConstraints(array $x): array;
}
