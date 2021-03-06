<?php


namespace Pinoven\Routing\Router;

use PHPUnit\Framework\TestCase;
use Pinoven\Routing\Route\Route;
use Pinoven\Routing\Router\RouteExpression\BracesRouteExpression;
use Pinoven\Routing\Router\RouteExpression\DigitBracesRouteExpression;
use Pinoven\Routing\Router\RouteRequest\RouteRequest;
use StdClass;

class RouteMatcherTest extends TestCase
{

    /**
     * @var RouteMatcher
     */
    private $routeMatcher;
    /**
     * @var StdClass
     */
    private $controller;

    public function setUp(): void
    {
        $this->routeMatcher = new RouteMatcher([
            new BracesRouteExpression(),
            new DigitBracesRouteExpression()
        ]);
        $this->controller = new class {
            public function helloWord(string $name)
            {
                return $name;
            }
            public function helloWorld2(string $name)
            {
                return 'Hello world ' . $name;
            }
        };
    }

    public function testGetRouteExpressions()
    {
        $routeExpressions = $this->routeMatcher->getRouteExpressions();
        $this->assertInstanceOf(BracesRouteExpression::class, $routeExpressions[0]);
        $this->assertInstanceOf(DigitBracesRouteExpression::class, $routeExpressions[1]);
    }

    public function testRouteDataIsNotRouteRequestInterface()
    {
        $route =  new Route('/hello/{name}', [$this->controller, 'helloWord']);
        $value = $this->routeMatcher->match([], $route);
        $this->assertNull($value);
    }

    public function testRouteMatched()
    {
        $route =  new Route('/hello/{name}', [$this->controller, 'helloWord']);
        $routeRequest =  new RouteRequest('https://www.test.com/hello/julien');
        $value = $this->routeMatcher->match($routeRequest, $route);
        $this->assertNotNull($value);
        $this->assertEquals(['name' => 'julien'], $value->getAttributes());
        $route2 =  new Route('/hello/{name}/{digit:year}/{month}', [$this->controller, 'helloWord']);
        $routeRequest2 =  new RouteRequest('https://www.test.com/hello/julien/2020/january');
        $value2 = $this->routeMatcher->match($routeRequest2, $route2);
        $this->assertNotNull($value2);
        $this->assertEquals(['name' => 'julien', 'year' => 2020, 'month' => 'january'], $value2->getAttributes());
        // Test route without variables.
        $route3 =  new Route('/hello', [$this->controller, 'helloWord']);
        $routeRequest3 =  new RouteRequest('https://www.test.com/hello');
        $value3 = $this->routeMatcher->match($routeRequest3, $route3);
        $this->assertNotNull($value3);
        $this->assertEquals([], $value3->getAttributes());
    }

    public function testRouteNotMatched()
    {
        $route =  new Route('/hello/dff/{name}', [$this->controller, 'helloWord']);
        $routeRequest =  new RouteRequest('https://www.test.com/hello/julien');
        $value = $this->routeMatcher->match($routeRequest, $route);
        $this->assertNull($value);
    }
}
