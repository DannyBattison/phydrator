# PHydrator

A simple utility library for entity hydration in PHP.

## Defining a Hydrator

All that should be necessary is to have an entity class (using PHP7.4+ property types), and then a very simple class such as this:

```php
namespace PHydrator\Hydrator;

use PHydrator\AbstractHydrator;

class SimpleHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = MyEntity::class;
}
```

## Quirks

The library will attempt to automatically register any hydrators using `get_declared_classes`.  However, if you're using autoloading (or even just loading the class before your hydrators), they won't be registered.

As a result, you should register your hydrators in your application:

```php
$pHydrator = new PHydrator();
$pHydrator->registerHydrator(SomeHydrator::class);
// ...
```
