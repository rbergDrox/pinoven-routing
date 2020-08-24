<?php


namespace Pinoven\Routing\Router;

use Pinoven\Routing\Route\RouteInterface;
use Pinoven\Routing\Router\RouteRequest\RouteResultInterface;

/**
 * Interface RouterInterface
 * @package Pinoven\Routing\Router
 */
interface RouterInterface
{

    /**
     * Get list of routes.
     *
     * @return iterable<RouteInterface>|null
     */
    public function routes(): ?iterable;

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
     * @return iterable<RouteResultInterface>
     * @see RouteMatcherInterface::match() Should be use there to check the list of routes.
     */
    public function find($routeData): iterable;


    /**
     * Find a route based on criteria.
     *
     * @param mixed $routeData
     * @return RouteResultInterface|null
     * @see RouteMatcherInterface::match() Should be use there to check the list of routes.
     */
    public function findOne($routeData): ?RouteResultInterface;

    /**
     * Get route by alias.
     *
     * @param string $alias
     * @return mixed
     */
    public function get(string $alias): ?RouteInterface;

    /**
     * Get the strategy to find a route from the router.
     *
     * @see RouteInterface::find() Find method will use this strategy.
     */
    public function getMatchRouteStrategy(): RouteMatcherInterface;
}
