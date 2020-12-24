<?php

namespace Phydrator;

use Phydrator\Exception\HydratorDoesNotExistException;
use ReflectionClass;

class Phydrator
{
    /** @var AbstractHydrator[] */
    private array $hydratorMap;

    public function __construct()
    {
        $classNames = get_declared_classes();
        $filteredClassNames = array_filter($classNames, function(string $className) {
            return is_subclass_of($className, AbstractHydrator::class);
        });

        $this->hydratorMap = [];

        foreach($filteredClassNames as $className) {
            try {
                $reflectionClass = new ReflectionClass($className);
                $this->hydratorMap[$reflectionClass->getConstant('ENTITY_CLASS')] = $className;
            } catch (\ReflectionException $e) { }
        }
    }

    public function hydrateOne(string $className, array $data): object
    {
        $hydrator = $this->getHydrator($className);
        if (!$hydrator) {
            throw new HydratorDoesNotExistException();
        }
        return $hydrator->hydrateOne($data);
    }

    public function hydrateMany(string $className, array $data): array
    {
        $hydrator = $this->getHydrator($className);
        if (!$hydrator) {
            throw new HydratorDoesNotExistException();
        }
        return $hydrator->hydrateMany($data);
    }

    public function getHydrator(string $className): ?AbstractHydrator
    {
        if (empty($this->hydratorMap[$className])) {
            return null;
        }

        $hydrator = $this->hydratorMap[$className];

        if (is_string($hydrator)) {
            $this->hydratorMap[$className] = new $hydrator($this);
        }

        return $this->hydratorMap[$className];
    }
}
