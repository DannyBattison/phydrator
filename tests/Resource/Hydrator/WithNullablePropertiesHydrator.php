<?php

namespace PHydrator\Tests\Resource\Hydrator;

use PHydrator\AbstractHydrator;
use PHydrator\Tests\Resource\Entity\WithNullableProperties;

class WithNullablePropertiesHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = WithNullableProperties::class;
}
