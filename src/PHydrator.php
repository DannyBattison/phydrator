<?php

namespace PHydrator;

use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use HaydenPierce\ClassFinder\ClassFinder;
use PHydrator\Exception\HydratorDoesNotExistException;
use ReflectionClass;
use ReflectionException;

class PHydrator
{
    /** @var AbstractHydrator[] */
    public array $hydratorMap = [];

	private Config $config;
    private ?AnnotationReader $annotationReader = null;

    public function __construct(?Config $config = null)
    {
		$this->config = $config ?? new Config();

		$this->autoloadHydrators();
    }

    public function hydrateOne(string $className, array $data): object
    {
        $hydrator = $this->getHydrator($className);
        if (!$hydrator) {
            throw new HydratorDoesNotExistException();
        }
        return $hydrator->hydrateOne($data);
    }

    public function hydrateMany(string $className, array $data): array
    {
        $hydrator = $this->getHydrator($className);
        if (!$hydrator) {
            throw new HydratorDoesNotExistException();
        }
        return $hydrator->hydrateMany($data);
    }

    public function getHydrator(string $className): ?AbstractHydrator
    {
        if (empty($this->hydratorMap[$className])) {
            return null;
        }

        $hydrator = $this->hydratorMap[$className];

        if (is_string($hydrator)) {
            $this->hydratorMap[$className] = new $hydrator($this);
        }

        return $this->hydratorMap[$className];
    }

    public function registerHydrator(string $className): void
    {
        try {
            $reflectionClass = new ReflectionClass($className);
            $this->hydratorMap[$reflectionClass->getConstant('ENTITY_CLASS')] = $className;
        } catch (ReflectionException $e) { }
    }

    public function getAnnotationReader(): AnnotationReader
    {
        if (!$this->annotationReader instanceof AnnotationReader) {
            $this->annotationReader = new AnnotationReader();
        }

        return $this->annotationReader;
    }

    private function autoloadHydrators(): void
    {
    	if (!$this->config->autoloadNamespace) {
    		return;
	    }

	    try {
		    $classNames = ClassFinder::getClassesInNamespace($this->config->autoloadNamespace);
	    } catch (Exception $e) {
	    	return;
	    }

	    $filteredClassNames = array_filter($classNames, static function(string $className) {
		    return is_subclass_of($className, AbstractHydrator::class);
	    });

	    foreach($filteredClassNames as $className) {
		    $this->registerHydrator($className);
	    }
    }
}
