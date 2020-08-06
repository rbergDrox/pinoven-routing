<?php


namespace Pinoven\Routing\Route;

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{

    public function testCreateRoute()
    {
        $controller = new class {
            public function helloWord(string $name)
            {
                return $name;
            }
            public function helloWorld2(string $name)
            {
                return 'Hello world ' . $name;
            }
        };
        $route =  new Route('/hello/{name}', [$controller, 'helloWord']);
        $this->assertEquals('/hello/{name}', $route->getPath());
        $route->setPath('/hello-updated/{name}');
        $this->assertEquals('/hello-updated/{name}', $route->getPath());
        $this->assertEquals('John', ($route->getDestination())('John'));
        $route->setDestination([$controller, 'helloWorld2']);
        $this->assertEquals('Hello world John', ($route->getDestination())('John'));
        $this->assertEmpty($route->getAttributes());
        $route->setAttributes(['priority' => 4]);
        $this->assertEquals(4, $route->getAttributes()['priority']);
        $route->setAttribute('priority', 6);
        $this->assertEquals(6, $route->getAttributes()['priority']);
        $this->assertNull($route->getAlias());
        $route->setAlias('myRoute');
        $this->assertEquals('myRoute', $route->getAlias());
    }
}
