<?php


namespace Pinoven\Routing\Router\RouteRequest;

use PHPUnit\Framework\TestCase;

class RouteRequestTest extends TestCase
{

    public function testRouteRequestValues()
    {
        $routeRequest =  new RouteRequest('https://www.test.com:3000/hello/julien#fragment');
        $this->assertEquals('https', $routeRequest->getScheme());
        $this->assertEquals('www.test.com', $routeRequest->getHost());
        $this->assertEquals(3000, $routeRequest->getPort());
        $this->assertEquals('/hello/julien', $routeRequest->getPath());
        $this->assertEquals('fragment', $routeRequest->getFragment());
        $routeRequest2 =  new RouteRequest('https://www.test.com/hello/julien?query=11&query2=22');
        $this->assertEquals('query=11&query2=22', $routeRequest2->getQuery());
        $routeRequest3 =  new RouteRequest('https://test:pjsje@www.test.com/hello/julien');
        $this->assertEquals('test', $routeRequest3->getUser());
        $this->assertEquals('pjsje', $routeRequest3->getPassword());
    }

    public function testRouteRequestValuesFragmentAndQueryAreDifferent() {
        $routeRequest =  new RouteRequest('https://www.test.com/hello/julien#fragment?query=11&query2=22');
        $this->assertEquals('fragment', $routeRequest->getFragment());
        $this->assertEquals('query=11&query2=22', $routeRequest->getQuery());
    }
}
