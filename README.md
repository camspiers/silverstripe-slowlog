# SilverStripe Slow Log

## Installation (with composer)

	composer require camspiers/silverstripe-slowlog:dev-master

## Usage

Provide a logger to the request filter service:

```yaml
Injector:
  SlowLogRequestFilter:
    constructor:
      0: '%$Monolog'
```