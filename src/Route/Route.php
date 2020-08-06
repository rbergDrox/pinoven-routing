<?php


namespace Pinoven\Routing\Route;

class Route implements RouteInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string|null
     */
    private $alias;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var callable
     */
    private $destination;

    public function __construct(string $path, callable $destination, ?string $alias = null)
    {
        $this->path = $path;
        $this->destination = $destination;
        $this->alias = $alias;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set route path.
     *
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * Set an alias for the route.
     *
     * @param string|null $alias
     */
    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }


    /**
     * @inheritDoc
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function setAttributes(array $attributes): RouteInterface
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setAttribute(string $key, $value): RouteInterface
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDestination(): callable
    {
        return $this->destination;
    }

    /**
     * Set the destination.
     *
     * @param callable $destination
     */
    public function setDestination(callable $destination): void
    {
        $this->destination = $destination;
    }
}
