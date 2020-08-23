<?php


namespace Pinoven\Routing\Router;

use Pinoven\Routing\Route\RouteInterface;

/**
 * Interface RouterInterface
 * @package Pinoven\Routing\Router
 */
interface RouterInterface
{

    /**
     * Get list of routes.
     *
     * @return iterable<RouteInterface>
     */
    public function routes(): iterable;

    /**
     * Add a route to the list of routes.
     * @param RouteInterface $route
     * @return $this
     */
    public function add(RouteInterface $route): self;

    /**
     * Remove a route from the list of routes.
     * @param RouteInterface $route
     * @return $this
     */
    public function remove(RouteInterface $route): self;


    /**
     * Find routes based on criteria.
     *
     * @param mixed $routeData
     * @return iterable<RouteInterface>
     * @see RouteMatcherInterface::match() Should be use there to check the list of routes.
     */
    public function find($routeData): iterable;


    /**
     * Find a route based on criteria.
     *
     * @param mixed $routeData
     * @return RouteInterface
     * @see RouteMatcherInterface::match() Should be use there to check the list of routes.
     */
    public function findOne($routeData): RouteInterface;

    /**
     * Get route by alias.
     *
     * @param string $alias
     * @return mixed
     */
    public function get(string $alias): ?RouteInterface;

    /**
     * Define the strategy to find a route from the router.
     *
     * @param RouteMatcherInterface $routerStrategy
     * @return $this
     * @see RouteInterface::find() Find method will use this strategy.
     */
    public function setMatchRouteStrategy(RouteMatcherInterface $routerStrategy): self;
}
