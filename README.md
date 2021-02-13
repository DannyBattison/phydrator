# PHydrator

A simple utility library for entity hydration in PHP.

## Defining a Hydrator

All that should be necessary is to have an entity class (using PHP7.4+ property types), and then a very simple class such as this:

```php
namespace PHydrator\Hydrator;

use PHydrator\AbstractHydrator;

class MyHydrator extends AbstractHydrator
{
    protected const ENTITY_CLASS = MyEntity::class;
}
```

## Autoloading Hydrators

The recommended method of registering hydrators is to specify a namespace in the config when initialising PHydrator:

```php
use PHydrator\Config;
use PHydrator\PHydrator;
// ...
$config = new Config();
$config->autoloadNamespace = "App\\Hydrators";
$pHydrator = new PHydrator($config);
// ...
```

If an autoload namespace isn't specified, you will need to manually register your hydrators.

Note that this is also an option if you have hydrators in other namespaces.

```php
use PHydrator\PHydrator;
// ...
$pHydrator = new PHydrator();
$pHydrator->registerHydrator(MyHydrator::class);
// ...
```
