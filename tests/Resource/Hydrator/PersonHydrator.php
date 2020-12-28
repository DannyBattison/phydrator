<?php

namespace PHydrator\Tests\Resource\Hydrator;

use PHydrator\AbstractHydrator;
use PHydrator\Tests\Resource\Entity\Person;

class PersonHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = Person::class;
}
