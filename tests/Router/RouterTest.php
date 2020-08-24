<?php


namespace Pinoven\Routing\Router;

use PHPUnit\Framework\TestCase;
use Pinoven\Routing\Route\RouteFactory;
use Pinoven\Routing\Route\RouteInterface;
use Pinoven\Routing\Router\RouteExpression\BracesRouteExpression;
use Pinoven\Routing\Router\RouteExpression\RouteExpressionInterface;
use Pinoven\Routing\Router\RouteRequest\RouteRequest;
use Pinoven\Routing\Router\RouteRequest\RouteResult;
use Pinoven\Routing\Router\RouteRequest\RouteResultInterface;

class RouterTest extends TestCase
{

    /**
     * @var Router
     */
    private $router;
    /**
     * @var \stdClas
     */
    private $controller;

    public function setUp(): void
    {
        $this->router =  new Router(new RouteMatcher(
            [new BracesRouteExpression()]
        ));
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

    public function testAddRoutes()
    {

        $route1 = RouteFactory::routeFromSettings([
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ]);
        $route2 = RouteFactory::routeFromSettings([
            'path' => '/hello/test/{name}',
            'destination' => [$this->controller, 'helloWorld2']
        ]);
        $this->assertNull($this->router->routes());
        $this->router->add($route1)->add($route2);
        $this->assertCount(2, $this->router->routes());
        $this->assertEquals('/hello/{name}', $this->router->routes()[0]->getPath());
        $this->assertEquals('/hello/test/{name}', $this->router->routes()[1]->getPath());
    }

    public function testRemoveRoute()
    {

        $route1 = RouteFactory::routeFromSettings([
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ]);
        $route2 = RouteFactory::routeFromSettings([
            'path' => '/hello/test/{name}',
            'destination' => [$this->controller, 'helloWorld2']
        ]);
        $this->assertNull($this->router->routes());
        $this->router->add($route1)->add($route2);
        $this->assertCount(2, $this->router->routes());
        $this->router->remove($route1);
        $this->assertCount(1, $this->router->routes());
        $this->assertEquals('/hello/test/{name}', $this->router->routes()[1]->getPath());
    }

    public function testGetRoute()
    {
        $route1 = RouteFactory::routeFromSettings([
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ]);
        $route2 = RouteFactory::routeFromSettings([
            'path' => '/hello/test/{name}',
            'destination' => [$this->controller, 'helloWorld2'],
            'alias' => 'the-route'
        ]);
        $this->assertNull($this->router->get('the-route'));
        $this->router->add($route1)->add($route2);
        $findRoute = $this->router->get('the-route');
        $this->assertNotNull($findRoute);
        $this->assertEquals('/hello/test/{name}', $findRoute->getPath());
        $this->assertNull($this->router->get('the-route-2'));
    }

    public function testFindRoutes()
    {
        $route1 = RouteFactory::routeFromSettings([
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ]);
        $route1dup = RouteFactory::routeFromSettings([
            'path' => '/hello/{firstname}',
            'destination' => [$this->controller, 'helloWorld2']
        ]);
        $route2 = RouteFactory::routeFromSettings([
            'path' => '/hello/test/{name}',
            'destination' => [$this->controller, 'helloWorld2'],
            'alias' => 'the-route'
        ]);
        $this->router->add($route1)->add($route2)->add($route1dup);
        $routeRequest = new RouteRequest('https://www.test.com/hello/jhon');
        $routes = $this->router->find($routeRequest);
        $this->assertCount(2, iterator_to_array($routes));
        $routeRequest2 = new RouteRequest('https://www.test.com/hello');
        $routes2 = $this->router->find($routeRequest2);
        $this->assertCount(0, iterator_to_array($routes2));
    }

    public function testFindOneRoute()
    {
        $route1 = RouteFactory::routeFromSettings([
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ]);
        $route1dup = RouteFactory::routeFromSettings([
            'path' => '/hello/{firstname}',
            'destination' => [$this->controller, 'helloWorld2']
        ]);
        $route2 = RouteFactory::routeFromSettings([
            'path' => '/hello/test/{name}',
            'destination' => [$this->controller, 'helloWorld2'],
            'alias' => 'the-route'
        ]);
        $this->router->add($route1)->add($route2)->add($route1dup);
        $routeRequest = new RouteRequest('https://www.test.com/hello/jhon');
        $routeResult = $this->router->findOne($routeRequest);
        $this->assertEquals('/hello/{name}', $routeResult->getRoute()->getPath());
    }

    public function testChangeRouteMatcher()
    {
        $routeMatcher = new class implements RouteMatcherInterface {

            /**
             * @return bool
             */
            public function hasTest()
            {
                return true;
            }

            /**
             * @inheritDoc
             */
            public function getRouteExpressions(): array
            {
                return [new BracesRouteExpression()];
            }

            /**
             * @inheritDoc
             */
            public function match($routeData, RouteInterface $route): ?RouteResultInterface
            {
                if ($routeData && $route) {
                    $test = ['name' => 'test'];
                    return new RouteResult($route, $test);
                }
                return null;
            }
        };
        $route = RouteFactory::routeFromSettings([
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ]);
        $this->router->add($route);
        $this->assertFalse(method_exists($this->router->getMatchRouteStrategy(), 'hasTest'));
        $this->router->setMatchRouteStrategy($routeMatcher);
        $this->assertTrue(method_exists($this->router->getMatchRouteStrategy(), 'hasTest'));
    }
}
