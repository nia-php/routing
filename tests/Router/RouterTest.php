<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) 2016 - Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Test\Nia\Routing\Router;

use PHPUnit_Framework_TestCase;
use Nia\Routing\Router\Router;
use Nia\Routing\Route\Route;
use Nia\Routing\Handler\HandlerInterface;
use Nia\Routing\Filter\FilterInterface;
use Nia\Routing\Condition\ConditionInterface;

/**
 * Unit test for \Nia\Routing\Router\Router.
 */
class RouterTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Routing\Router\Router::__construct
     * @covers \Nia\Routing\Router\Router::addRoute
     * @covers \Nia\Routing\Router\Router::getRoutes
     */
    public function testAddRouteGetRoutes()
    {
        $condition = $this->getMock(ConditionInterface::class);
        $filter = $this->getMock(FilterInterface::class);
        $handler = $this->getMock(HandlerInterface::class);

        $routeOne = new Route($condition, $filter, $handler);
        $routeTwo = new Route($condition, $filter, $handler);

        $router = new Router([
            $routeOne
        ]);

        $this->assertEquals([
            $routeOne
        ], $router->getRoutes());

        $this->assertSame($router, $router->addRoute($routeTwo));
        $this->assertEquals([
            $routeOne,
            $routeTwo
        ], $router->getRoutes());
    }
}
