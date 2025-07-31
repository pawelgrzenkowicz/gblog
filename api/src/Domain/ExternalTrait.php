<?php

declare(strict_types=1);

namespace App\Domain;

use Exception;
use ReflectionClass;
use ReflectionException;

trait ExternalTrait
{
    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function update(array $values): void
    {
        $reflection = new ReflectionClass($this);

        foreach ($values as $name => $value) {

            try {
                $property = $reflection->getProperty($name);
            } catch (Exception $exception) {
                throw new Exception('PROPERTY_DOES_NOT_EXIST');
            }

            if (null === $external = $property->getAttributes(External::class)[0] ?? null) {
                throw new Exception('CANNOT_MODIFY_PROPERTY');
            }

            $this->$name = $value;
        }
    }
}
