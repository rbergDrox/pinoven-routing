<?php


namespace Pinoven\Routing\Router;

use Pinoven\Routing\Router\RouteExpression\RouteExpressionInterface;
use Pinoven\Routing\Route\RouteInterface;
use Pinoven\Routing\Router\RouteRequest\RouteResultInterface;

/**
 * Define how to find a route base on route data we are trying to retrieve.
 *
 * Interface RouteMatcherInterface
 * @package Pinoven\Routing\Router
 */
interface RouteMatcherInterface
{
    /**
     * Get the list of expressions to detect.
     *
     * @return RouteExpressionInterface[]
     */
    public function getRouteExpressions(): array;

    /**
     * Check if a route match to whatever we sent as a route information.
     *
     * @param mixed $routeData
     * @param RouteInterface $route
     * @return RouteResultInterface|null
     */
    public function match($routeData, RouteInterface $route): ?RouteResultInterface;
}
