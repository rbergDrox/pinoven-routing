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
}
