<?php


namespace Pinoven\Routing\Router;

use Pinoven\Routing\Route\RouteInterface;

/**
 * Define how to find a route base on route data we are trying to retrieve.
 *
 * Interface RouteMatcherInterface
 * @package Pinoven\Routing\Router
 */
interface RouteMatcherInterface
{
    /**
     * Check if a route match to whatever we sent as a route information.
     *
     * @param mixed $routeData
     * @param RouteInterface $route
     * @return bool
     */
    public function match($routeData, RouteInterface $route): bool;
}
