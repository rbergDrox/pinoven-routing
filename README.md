# Pinoven: Routing  [![Pinoven](https://circleci.com/gh/rbergDrox/pinoven-routing.svg?style=svg)](https://circleci.com/gh/rbergDrox/pinoven-routing/tree/master)

Pinoven Routing 
# Install

```
$ composer require pinoven/routing
```

# Features/Usage

## Interface
The component is provided with a set of interface:
```php
// Describe how you can create router from settings.
\Pinoven\Routing\Route\RouteFactoryInterface::class;

// Describe element that have to be in a route and nothing else.
\Pinoven\Routing\Route\RouteInterface::class;

// Describe element that have to be in a router and nothing else.
\Pinoven\Routing\Router\RouterInterface::class;

// Should be use by the router to match a route.
\Pinoven\Routing\Router\RouteMatcherInterface::class;

```

## Route

## Matcher

## Router

# Contribution
 - Create issue: improvement + the reason why it should be implemented or issue + how to reproduce.
 - Create pull request  and explain the issue.
 
More information will come about how to contribute on all pinoven package.
