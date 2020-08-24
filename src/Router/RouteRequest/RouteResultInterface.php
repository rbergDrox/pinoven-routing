<?php


namespace Pinoven\Routing\Router\RouteRequest;

use Pinoven\Routing\Route\RouteInterface;

interface RouteResultInterface
{

    /**
     * Get the route bind to the request.
     *
     * @return RouteInterface
     */
    public function getRoute(): RouteInterface;

    /**
     * Get attributes from dynamic value.
     *
     * @return array
     */
    public function getAttributes(): array;
}
