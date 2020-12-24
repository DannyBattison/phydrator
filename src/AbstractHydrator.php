<?php

namespace Phydrator;

use ReflectionClass;
use TypeError;

abstract class AbstractHydrator
{
    protected const ENTITY_CLASS = '';

    private Phydrator $phydrator;

    /** @var string[] */
    private array $propTypes = [];

    public function __construct(Phydrator $phydrator)
    {
        $this->phydrator = $phydrator;

        $reflectionClass = new ReflectionClass(static::ENTITY_CLASS);
        $props = $reflectionClass->getProperties();

        foreach ($props as $prop) {
            $this->propTypes[$prop->getName()] = $prop->getType()->getName();
        }
    }

    public function hydrateOne($data): object
    {
        $entityClass = static::ENTITY_CLASS;
        $entity = new $entityClass();

        foreach ($data as $key => $val) {
            try {
                if (!empty($this->propTypes[$key])) {
                    $hydrator = $this->phydrator->getHydrator($this->propTypes[$key]);
                    $entity->$key = $hydrator ? $hydrator->hydrateOne($val) : $val;
                }
            } catch (TypeError $e) { }
        }

        return $entity;
    }

    public function hydrateMany($data): array
    {
        return array_map(function(array $element) {
            return $this->hydrateOne($element);
        }, $data);
    }
}
