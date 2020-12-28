<?php

namespace PHydrator\Tests\Resource\Hydrator;

use PHydrator\AbstractHydrator;
use PHydrator\Tests\Resource\Entity\Cat;

class CatHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = Cat::class;
}
