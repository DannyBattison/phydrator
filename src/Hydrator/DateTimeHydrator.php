<?php

namespace PHydrator\Hydrator;

use DateTime;
use PHydrator\AbstractHydrator;

class DateTimeHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = DateTime::class;

    public function hydrateOne($data): object
    {
        return new DateTime($data);
    }
}
