# Domain-Driven Design Maker for Symfony applications

This bundle assumes you are using https://github.com/yceruto/symfony-ddd-skeleton architecture or similar.

## Installation

    composer require yceruto/ddd-maker-bundle

## Maker

 * `bin/console make:ddd:context admin` Creates a new Kernel context skeleton
 * `bin/console make:ddd:module catalog/listing` Creates a new Module skeleton
 * `bin/console make:ddd:event catalog/listing published` Creates a new Domain Event
 * `bin/console make:ddd:event-subscriber catalog/listing published` Creates a new Domain Event Subscriber
 * `bin/console make:cqs:command catalog/listing publish` Creates a new Command use-case
 * `bin/console make:cqs:query catalog/listing find` Creates a new Query use-case

Note: In all cases the namespace path (e.g. `catalog/listing`) will be normalized to the corresponding PHP namespace and 
directory structure convention following the DDD approach.

## License

This software is published under the [MIT License](LICENSE)
