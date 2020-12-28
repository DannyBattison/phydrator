<?php

namespace PHydrator\Tests\Resource\Entity;

use \PHydrator\Annotation\Hydrator;

class Person
{
    public string $class;

    /**
     * @var Cat[]
     * @Hydrator(entityClass=Cat::class, type=Hydrator::TYPE_MANY)
     */
    public array $cats;
}
