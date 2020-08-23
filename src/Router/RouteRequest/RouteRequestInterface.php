<?php


namespace Pinoven\Routing\Router\RouteRequest;

interface RouteRequestInterface
{
    /**
     * @return string|null
     */
    public function getScheme(): ?string;

    /**
     * @return string|null
     */
    public function getHost(): ?string;

    /**
     * @return int|null
     */
    public function getPort(): ?int;

    /**
     * @return string|null
     */
    public function getUser(): ?string;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string|null
     */
    public function getQuery(): ?string;

    /**
     * @return string|null
     */
    public function getFragment(): ?string;
}
