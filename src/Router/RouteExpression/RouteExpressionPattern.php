<?php


namespace Pinoven\Routing\Router\RouteExpression;

trait RouteExpressionPattern
{
    /**
     * Get the pattern related to an expression.
     *
     * @return string
     */
    public function pattern(): string
    {
        return '\w+';
    }
}
