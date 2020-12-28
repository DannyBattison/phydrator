<?php

namespace PHydrator;

use Doctrine\Common\Annotations\AnnotationReader;
use Phydrator\Annotation\Hydrator;
use ReflectionClass;
use TypeError;

abstract class AbstractHydrator
{
    protected const ENTITY_CLASS = '';

    private PHydrator $pHydrator;

    /** @var Hydrator[] */
    private array $propertyHydrators = [];

    public function __construct(PHydrator $pHydrator)
    {
        $this->pHydrator = $pHydrator;

        $reflectionClass = new ReflectionClass(static::ENTITY_CLASS);
        $props = $reflectionClass->getProperties();

        foreach ($props as $prop) {
            $type = $prop->getType()->getName();
            $annotation = $this->pHydrator
                ->getAnnotationReader()
                ->getPropertyAnnotation($prop, Hydrator::class);

            if ($annotation instanceof Hydrator) {
                $this->propertyHydrators[$prop->getName()] = $annotation;
                continue;
            }

            $this->propertyHydrators[$prop->getName()] = new Hydrator([
                'entityClass' => $type,
            ]);
        }
    }

    public function hydrateOne($data): object
    {
        $entityClass = static::ENTITY_CLASS;
        $entity = new $entityClass();

        foreach ($data as $key => $val) {
            try {
                if (!empty($this->propertyHydrators[$key])) {
                    $propertyHydrator = $this->propertyHydrators[$key];
                    $hydrator = $this->pHydrator->getHydrator($propertyHydrator->entityClass);
                    $entity->$key = $hydrator ? $hydrator->{$propertyHydrator->type}($val) : $val;
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
