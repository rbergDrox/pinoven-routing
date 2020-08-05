<?php


namespace Pinoven\Routing\Route;

/**
 * Interface RouteInterface
 * @package Pinoven\Routing\Route
 *
 */
interface RouteInterface
{


    /**
     * Get route path.
     *
     * @return string
     */
    public function getPath():string;

    /**
     * Get the route alias.
     *
     * @return string|null
     */
    public function getAlias(): ?string;


    /**
     * Get the attributes key/value.
     *
     * @return array
     */
    public function getAttributes(): array;


    /**
     * Set an attribute key/value.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttributes(string $key, $value): self;

    /**
     * Get the destination of  this route.
     *
     * @return callable
     */
    public function getDestination(): callable;
}
