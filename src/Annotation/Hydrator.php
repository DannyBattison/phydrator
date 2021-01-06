<?php

namespace PHydrator\Annotation;

/**
 * @Annotation
 */
final class Hydrator
{
    public const TYPE_ONE = 'hydrateOne';
    public const TYPE_MANY = 'hydrateMany';

    public string $entityClass;
    public string $type;
    public bool $nullable;

    public function __construct(array $values)
    {
        $this->entityClass = $values['entityClass'];
        $this->type = $values['type'] ?? self::TYPE_ONE;
        $this->nullable = $values['nullable'] ?? false;
    }
}
