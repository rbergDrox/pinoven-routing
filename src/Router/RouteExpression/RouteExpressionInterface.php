<?php


namespace Pinoven\Routing\Router\RouteExpression;

interface RouteExpressionInterface
{

    /**
     * Get the beginning of string for an expression.
     *
     * @return string
     */
    public function start(): string;

    /**
     * Get then end string for an expression.
     *
     * @return string
     */
    public function end(): string;

    /**
     * Get the pattern related to an expression.
     *
     * @return string
     */
    public function pattern(): string;
}
