<?php

namespace Phydrator;

use TypeError;

abstract class AbstractHydrator
{
    protected const ENTITY_CLASS = '';

    private HydratorRepository $hydratorRepository;

    public function __construct(HydratorRepository $hydratorRepository)
    {
        $this->hydratorRepository = $hydratorRepository;
    }

    public function hydrateOne(object $data): object
    {
        $entityClass = static::ENTITY_CLASS;
        $entity = new $entityClass();

        foreach ($data as $key => $val) {
            try {
                if (property_exists(static::$entityClass, $key)) {
                    var_dump(gettype($entity->$key));exit;
                    $entity->$key = $val;
                }
            } catch (TypeError $e) { }
        }

        return $entity;
    }

    public function hydrateMany(array $data): array
    {
        return array_map(function(object $element) {
            return $this->hydrateOne($element);
        }, $data);
    }
}
