<?php


namespace Pinoven\Routing\Router;

use Pinoven\Routing\Route\RouteInterface;

class Router implements RouterInterface
{
    /**
     * @var RouteMatcherInterface
     */
    private $routeMatcher;

    /**
     * @var iterable<RouteInterface>
     */
    private $routes;


    /**
     * Router constructor.
     *
     * @param RouteMatcherInterface $routeMatcher
     */
    public function __construct(RouteMatcherInterface $routeMatcher)
    {
        $this->routeMatcher = $routeMatcher;
    }

    /**
     * @inheritDoc
     */
    public function routes(): ?iterable
    {
        return $this->routes;
    }

    /**
     * @inheritDoc
     */
    public function add(RouteInterface $route): RouterInterface
    {
        $this->routes[] = $route;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function remove(RouteInterface $route): RouterInterface
    {
        foreach ($this->routes as $key => $route) {
            /** @var RouteInterface $route */
            if ($route->getPath() === $route->getPath()) {
                unset($this->routes[$key]);
                break;
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function find($routeData): iterable
    {
        if (!empty($this->routes)) {
            foreach ($this->routes as $route) {
                $findRoute = $this->routeMatcher->match($routeData, $route);
                if ($findRoute) {
                    yield $route;
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function findOne($routeData): ?RouteInterface
    {
        $routes = $this->find($routeData);
        $findRoute = null;
        foreach ($routes as $route) {
            $findRoute = $route;
            break;
        }
        return $findRoute;
    }

    /**
     * @inheritDoc
     */
    public function get(string $alias): ?RouteInterface
    {
        if (!empty($this->routes)) {
            foreach ($this->routes as $route) {
                /** @var RouteInterface $route */
                if ($route->getAlias() === $alias) {
                    return $route;
                }
            }
        }
        return null;
    }

    /**
     * Define the strategy to find a route from the router.
     *
     * @param RouteMatcherInterface $routerStrategy
     * @return $this
     * @see RouteInterface::find() Find method will use this strategy.
     */
    public function setMatchRouteStrategy(RouteMatcherInterface $routerStrategy): RouterInterface
    {
        $this->routeMatcher = $routerStrategy;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMatchRouteStrategy(): RouteMatcherInterface
    {
        return $this->routeMatcher;
    }
}
