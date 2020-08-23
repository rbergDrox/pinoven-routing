<?php


namespace Pinoven\Routing\Router;

use Pinoven\Routing\Router\RouteExpression\RouteExpressionInterface;
use Pinoven\Routing\Route\RouteInterface;
use Pinoven\Routing\Router\RouteRequest\RouteRequestInterface;

class RouteMatcher implements RouteMatcherInterface
{
    /**
     * @var RouteExpressionInterface[]
     *
     */
    private $routeExpressions;

    /**
     * RouteMatcher constructor.
     * @param RouteExpressionInterface[] $routeExpressions
     */
    public function __construct(array $routeExpressions)
    {
        $this->routeExpressions = $routeExpressions;
    }


    /**
     * @inheritDoc
     */
    public function match($routeData, RouteInterface $route): ?array
    {
        if (!is_a($routeData, RouteRequestInterface::class)) {
            return null;
        }
        $pattern = $route->getPath();
        $attributes = [];
        foreach ($this->getRouteExpressions() as $routeExpression) {
            $regex = "/({$routeExpression->start()}\w+{$routeExpression->end()})/i";
            preg_match_all($regex, $route->getPath(), $matches);
            foreach ($matches[1] as $match) {
                /** @var string $attributeStart */
                $attributeStart = substr($match, strlen($routeExpression->start()));
                $attribute = substr($attributeStart, 0, strlen($attributeStart) - strlen($routeExpression->end()));
                $attributes[$attribute] = null;
                $pattern = str_replace($match, "(?P<{$attribute}>{$routeExpression->pattern()})", $pattern);
            }
        }
        $routeMatches = [];
        $pattern = str_replace('/', '\/', $pattern);
        preg_match_all('/'. $pattern.'/i', $routeData->getPath(), $routeMatches);
        if ($routeMatches && isset($routeMatches[0][0])  && $routeMatches[0][0] === $routeData->getPath()) {
            foreach ($routeMatches as $keyRouteMatch => $routeMatch) {
                if ($keyRouteMatch === 0) {
                    continue;
                }
                if (array_key_exists($keyRouteMatch, $attributes)) {
                    $attributes[$keyRouteMatch] = $routeMatch[0];
                }
            }
        }
        // Clean attributes having get no value.
        $attributes = array_filter($attributes, function ($attr) {
            if (is_null($attr)) {
                return false;
            }
            return true;
        });
        return $attributes ? : null;
    }

    /**
     * @inheritDoc
     */
    public function getRouteExpressions(): array
    {
        return $this->routeExpressions;
    }
}
