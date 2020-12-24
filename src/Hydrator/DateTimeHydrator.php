<?php

namespace Phydrator\Hydrator;

use DateTime;
use Phydrator\AbstractHydrator;

class DateTimeHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = DateTime::class;

    public function hydrateOne($data): object
    {
        return new DateTime($data);
    }
}
