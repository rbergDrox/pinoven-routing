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
\Pinoven\Routing\Router\RouteInterface::class;

// Should be use by the router to match a route.
\Pinoven\Routing\Router\RouteMatcherInterface::class;

```

## Route

### Definition

```php

$controller = new class {
    public function hellWord() {
    
    }
    public function newRoute() {
   
    } 
};
$route =  new \Pinoven\Routing\Route\Route('/my-route/{test}', [$controller, 'helloWord']);

$routeWithAlias =  new \Pinoven\Routing\Route\Route('/my-next-route/{test1}/{test2}', [$controller, 'newRoute'], 'route-alias');
```

You can use getter/setter to change these values.

You can add/update attributes on this route by using this:
```php
$controller = new class {
    public function helloWord() {
    
    }
};
$route =  new \Pinoven\Routing\Route\Route('/my-route/{test}', [$controller, 'helloWord']);

$route->setAttributes('priority', 4);
```
### Factory

By using an array you can create a route:

```php
use Pinoven\Routing\Route\RouteFactory;

$controller = new class {
    // ... Controller definition
};
$routeFactory = new RouteFactory();
$config = [
    'path' => '/hello/{name}',
    'alias' => 'mon-alias',
    'destination' => [$controller, 'methodToCall'],
    'attributes' => [
        'priority' => 6,
        'enabled' => false,
    ]
];
$route = $routeFactory->configure($config);
```

## Matcher
A route matcher is something that the router will use to found if a routing request has one or more route that can be bind.

```php
use Pinoven\Routing\Route\RouteFactory;

$controller = new class {
    // ... Controller definition
};
$routeFactory = new RouteFactory();
$config = [
    'path' => '/hello/{name}',
    'alias' => 'mon-alias',
    'destination' => [$controller, 'methodToCall']
];
$route = $routeFactory->configure($config);

// Default expressions that can be used as delimiter for attributes.
$defaultExpressions = [
    new \Pinoven\Routing\Router\RouteExpression\BracesRouteExpression(),
    new \Pinoven\Routing\Router\RouteExpression\DigitBracesRouteExpression()
];
$matcher = new \Pinoven\Routing\Router\RouteMatcher($defaultExpressions);

// $routeRequestData can be a RouteRequest or whatever you want to use to check if the route match with routing request. 
$routeRequestData = new \Pinoven\Routing\Router\RouteRequest\RouteRequest('https://www.test.com/test');
// It will return an empty array or with attributes or null if nothing matches.
$matcher->match($routeRequestData, $route);
```

## Router

```php
// Default expressions that can be used as delimiter for attributes.
$defaultExpressions = [
    new \Pinoven\Routing\Router\RouteExpression\BracesRouteExpression(),
    new \Pinoven\Routing\Router\RouteExpression\DigitBracesRouteExpression()
];
$matcher = new \Pinoven\Routing\Router\RouteMatcher($defaultExpressions);
$router = new \Pinoven\Routing\Router\Router($matcher);

// Default route matcher can be change
$routeMatcher = new class implements \Pinoven\Routing\Router\RouteMatcherInterface {
     public function getRouteExpressions() : array{
    }
    public function match($routeData,\Pinoven\Routing\Route\RouteInterface $route) : ?\Pinoven\Routing\Router\RouteRequest\RouteResultInterface{
  
    }
};
// must implement RoutMatcherInterface
$router->setMatchRouteStrategy($routeMatcher);
```
### Route result

Route matching a routing request will be wrapped to a `RouteResult` instance.
That one implements :
```php
\Pinoven\Routing\Router\RouteRequest\RouteResultInterface::class;
```

# Contribution

Route methods(add, remove, find, findOne, get) should use  strategy. We able to  implement whatever w want here such  as collection.

# Contribution
 - Create issue: improvement + the reason why it should be implemented or issue + how to reproduce.
 - Create pull request  and explain the issue.
 
More information will come about how to contribute on all pinoven package.
