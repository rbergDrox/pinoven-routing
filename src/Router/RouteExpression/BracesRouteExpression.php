<?php


namespace Pinoven\Routing\Router\RouteExpression;

use Pinoven\Routing\Router\RouteExpression\RouteExpressionInterface;

class BracesRouteExpression implements RouteExpressionInterface
{

    use RouteExpressionPattern;

    public function start(): string
    {
        return '{';
    }

    public function end(): string
    {
        return '}';
    }
}
