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
    public function setAttribute(string $key, $value): self;

    /**
     * Set attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes): self;

    /**
     * Get the destination of  this route.
     *
     * @return callable
     */
    public function getDestination(): callable;
}
