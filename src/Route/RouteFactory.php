<?php


namespace Pinoven\Routing\Route;

use ReflectionException;

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
     * @return Route|RouteInterface|null
     * @throws ReflectionException Can retrieve method from route.
     */
    public static function routeFromSettings(array $settings, ?RouteInterface $route = null)
    {
        $route = $route ? : self::createRoute($settings);
        unset($settings['path']);
        unset($settings['destination']);
        unset($settings['alias']);
        foreach ($settings as $settingKey => $settingValue) {
            $method = 'set' . ucfirst($settingKey);

            if (method_exists($route, $method)) {
                $reflectionMethod = new \ReflectionMethod($route, $method);
                $countOfParameters = $reflectionMethod->getNumberOfParameters();
                if ($countOfParameters === 1) {
                    $route->{$method}($settingValue);
                } elseif ($countOfParameters > 1) {
                    $route->{$method}(...$settingValue);
                }
            }
        }
        return $route;
    }
}
