<?php


namespace Pinoven\Routing\Router\RouteExpression;

use Pinoven\Routing\Router\RouteExpression\RouteExpressionInterface;

class DigitBracesRouteExpression implements RouteExpressionInterface
{

    public function start(): string
    {
        return '{digit:';
    }

    public function end(): string
    {
        return '}';
    }

    /**
     * Get the pattern related to an expression.
     *
     * @return string
     */
    public function pattern(): string
    {
        return '\d+';
    }
}
