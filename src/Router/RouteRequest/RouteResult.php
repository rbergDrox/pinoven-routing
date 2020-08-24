<?php


namespace Pinoven\Routing\Router\RouteRequest;

use Pinoven\Routing\Route\RouteInterface;

class RouteResult implements RouteResultInterface
{
    /**
     * @var RouteInterface
     */
    private $route;
    /**
     * @var array
     */
    private $attributes;

    /**
     * RouteResult constructor.
     *
     * @param RouteInterface $route
     * @param array $attributes
     */
    public function __construct(RouteInterface $route, array $attributes)
    {
        $this->route = $route;
        $this->attributes = $attributes;
    }

    /**
     * @inheritDoc
     */
    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
