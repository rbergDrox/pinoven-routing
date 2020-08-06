<?php


namespace Pinoven\Routing\Route;

use ReflectionException;
use ReflectionMethod;

/**
 * Interface RouteFactory
 * @package Pinoven\Routing\Route
 *
 */
class RouteFactory implements RouteFactoryInterface
{

    /**
     * @inheritDoc
     * @throws RouteConfigurationException If `path`, `destination` are missing.
     * @throws ReflectionException  Can retrieve methods and set parameters for the route.
     */
    public function configure(array $routeConfiguration): RouteInterface
    {
        return self::routeFromSettings($routeConfiguration);
    }

    /**
     * Create a route object base on `path`, `destination` and `alias`.
     *
     * @param array $settings
     * @return Route
     */
    public static function createRoute(array $settings)
    {
        if (is_null($settings['path'] ?? null)) {
            throw new RouteConfigurationException('`path` is missing');
        }
        if (is_null($settings['destination'] ?? null)) {
            throw new RouteConfigurationException('`destination` is missing');
        }
        $alias = $settings['alias'] ?? null;
        return new Route($settings['path'], $settings['destination'], $alias);
    }

    /**
     * Create route object.
     *
     * @param array $settings
     * @param RouteInterface|null $route
     * @param bool $overridePath
     * @param bool $overrideDestination
     * @param bool $overrideAlias
     * @return Route|RouteInterface|null
     * @throws ReflectionException Can retrieve method from route.
     */
    public static function routeFromSettings(
        array $settings,
        ?RouteInterface $route = null,
        bool $overridePath = false,
        bool $overrideDestination = false,
        bool $overrideAlias = false
    ) {
        $route = $route ? : self::createRoute($settings);
        if (!$overridePath) {
            unset($settings['path']);
        }
        if (!$overrideDestination) {
            unset($settings['destination']);
        }
        if (!$overrideAlias && $route->getAlias()) {
            unset($settings['alias']);
        }
        self::routeConfigBySetter($route, $settings);
        return $route;
    }

    /**
     * Update route attributes by using setters.
     *
     * @param RouteInterface $route
     * @param array $settings
     * @throws ReflectionException
     */
    protected static function routeConfigBySetter(RouteInterface $route, array $settings)
    {
        foreach ($settings as $settingKey => $settingValue) {
            $method = 'set' . ucfirst($settingKey);
            $countOfParameters = null;
            if (method_exists($route, $method)) {
                $reflectionMethod = new ReflectionMethod($route, $method);
                $countOfParameters = $reflectionMethod->getNumberOfParameters();
            }
            if ($countOfParameters === 1) {
                $route->{$method}($settingValue);
            } elseif ($countOfParameters > 1) {
                $route->{$method}(...$settingValue);
            }
        }
    }
}
