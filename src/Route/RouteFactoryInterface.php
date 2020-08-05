<?php


namespace Pinoven\Routing\Route;

/**
 * Interface RouteFactoryInterface
 * @package Pinoven\Routing\Route
 *
 */
interface RouteFactoryInterface
{

    /**
     * Create a route (RouteInterface).
     *
     * @param array $routeConfiguration
     * @return RouteInterface
     */
    public function configure(array $routeConfiguration): RouteInterface;
}
