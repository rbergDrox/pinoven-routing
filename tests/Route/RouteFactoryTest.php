<?php


namespace Pinoven\Routing\Route;

use PHPUnit\Framework\TestCase;

class RouteFactoryTest extends TestCase
{

    /**
     * @var object
     */
    private $controller;

    public function setUp(): void
    {
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


    public function testConfigure()
    {
        $routeFactory = new RouteFactory();
        $config = [
            'path' => '/hello/{name}',
            'destination' => [$this->controller, 'helloWord']
        ];
        $route = $routeFactory->configure($config);
        $this->assertEquals($config['path'], $route->getPath());
        $this->assertEquals('John', ($route->getDestination())('John'));
        $this->assertNull($route->getAlias());
        $config2 = [
            'path' => '/hello/{name}',
            'alias' => 'mon-alias',
            'destination' => [$this->controller, 'helloWorld2'],
            'attributes' => [
                'priority' => 6,
                'enabled' => false,
            ]
        ];
        $route2 = $routeFactory->configure($config2);
        $this->assertEquals($config2['path'], $route2->getPath());
        $this->assertEquals('Hello world John', ($route2->getDestination())('John'));
        $this->assertEquals($config2['alias'], $route2->getAlias());
        $this->assertEquals($config2['attributes'], $route2->getAttributes());
    }

    public function testConfigurePathMissing()
    {
        $config = [
            'destination' => [$this->controller, 'helloWord']
        ];
        $routeFactory = new RouteFactory();
        $this->expectException(RouteConfigurationException::class);
        $this->expectExceptionMessage('`path` is missing');
        $routeFactory->configure($config);
    }

    public function testConfigureDestinationMissing()
    {
        $config = [
            'path' => '/hello/{name}',
        ];
        $routeFactory = new RouteFactory();
        $this->expectException(RouteConfigurationException::class);
        $this->expectExceptionMessage('`destination` is missing');
        $routeFactory->configure($config);
    }

    public function testConfigureRouteWithMethodsMultiArgs()
    {
        $route = new class('/path/test', [$this->controller, 'helloWord']) extends Route {

            public $test = [];
            public $test2 = [];
            public $test3 = [];

            public function setTest($test, $test2, $test3)
            {
                $this->test = [$test, $test2, $test3];
            }

            public function setTest2($test)
            {
                $this->test2 = [$test];
            }

            public function setTest3($test, $test2)
            {
                $this->test3 = [$test, $test2];
            }
        };
        $config = [
            'path' => '/hello/{name}',
            'alias' => 'mon-alias',
            'destination' => [$this->controller, 'helloWorld2'],
            'test' => [1, 2, 3],
            'test2' => [4, 5],
            'test3' => [6, 7]
        ];
        $this->assertEquals('/path/test', $route->getPath());
        $this->assertEquals('John', ($route->getDestination())('John'));
        $this->assertNull($route->getAlias());
        RouteFactory::routeFromSettings($config, $route);
        $this->assertEquals('/path/test', $route->getPath());
        $this->assertEquals('John', ($route->getDestination())('John'));
        $this->assertEquals($config['alias'], $route->getAlias());
        $this->assertEquals([1, 2, 3], $route->test);
        $this->assertEquals([[4, 5]], $route->test2);
        $this->assertEquals([6, 7], $route->test3);

        $config2 = [
            'path' => '/hello/{name}',
            'alias' => 'mon-alias-2',
            'destination' => [$this->controller, 'helloWorld2'],
            'test' => [1, 2, 3],
            'test2' => [4, 5],
            'test3' => [6, 7]
        ];
        RouteFactory::routeFromSettings($config2, $route, true, true, true);
        $this->assertEquals($config2['path'], $route->getPath());
        $this->assertEquals('Hello world John', ($route->getDestination())('John'));
        $this->assertEquals($config2['alias'], $route->getAlias());
    }
}
