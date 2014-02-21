# SilverStripe Slow Log

[![Build Status](https://travis-ci.org/camspiers/silverstripe-slowlog.png?branch=master)](https://travis-ci.org/camspiers/silverstripe-slowlog)

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

## Define a custom time

Any request >1s is deemed "slow" by default you can change this as follows:

```yaml
Injector:
  SlowLogRequestFilter:
    constructor:
      0: '%$Monolog'
      1: 2
```
