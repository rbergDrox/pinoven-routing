<?php


namespace Pinoven\Routing\Router\RouteRequest;

class RouteRequest implements RouteRequestInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * RouteRequest constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function getScheme(): ?string
    {
        return parse_url($this->url, PHP_URL_SCHEME);
    }

    /**
     * @inheritDoc
     */
    public function getHost(): ?string
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    /**
     * @inheritDoc
     */
    public function getPort(): ?int
    {
        return parse_url($this->url, PHP_URL_PORT);
    }

    public function getUser(): ?string
    {
        return parse_url($this->url, PHP_URL_USER);
    }

    public function getPassword(): ?string
    {
        return parse_url($this->url, PHP_URL_PASS);
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return parse_url($this->url, PHP_URL_PATH);
    }

    public function getQuery(): ?string
    {
        $query = parse_url($this->url, PHP_URL_QUERY);
        if (is_null($query) && $this->getFragment()) {
            $fragment = parse_url($this->url, PHP_URL_FRAGMENT);
            $fragmentMixedQuery =  strpos($fragment, '?');
            $query =  $fragmentMixedQuery !== false ?  substr($fragment, $fragmentMixedQuery + 1) : null;
        }
        return $query;
    }

    /**
     * @inheritDoc
     */
    public function getFragment(): ?string
    {
        $fragment = parse_url($this->url, PHP_URL_FRAGMENT);
        $fragmentMixedQuery =  strpos($fragment, '?');
        if ($fragmentMixedQuery !== false) {
            $fragment = substr($fragment, 0, $fragmentMixedQuery);
        }
        return $fragment;
    }
}
