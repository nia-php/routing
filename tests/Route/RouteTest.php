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
namespace Test\Nia\Routing\Route;

use PHPUnit_Framework_TestCase;
use Nia\Routing\Route\Route;
use Nia\Routing\Filter\FilterInterface;
use Nia\Routing\Condition\ConditionInterface;
use Nia\Routing\Handler\HandlerInterface;

/**
 * Unit test for \Nia\Routing\Route\Route.
 */
class RouteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \Nia\Routing\Route\Route
     */
    public function testMethods()
    {
        $condition = $this->getMock(ConditionInterface::class);
        $filter = $this->getMock(FilterInterface::class);
        $handler = $this->getMock(HandlerInterface::class);

        $route = new Route($condition, $filter, $handler);

        $this->assertSame($condition, $route->getCondition());
        $this->assertSame($filter, $route->getFilter());
        $this->assertSame($handler, $route->getHandler());
    }
}
