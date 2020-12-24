# PHydrator

A simple utility library for entity hydration in PHP.

## Quirks

The library will attempt to automatically register any hydrators using `get_declared_classes`.  However, if you're using autoloading (or even just loading the class before your hydrators), they won't be registered.
