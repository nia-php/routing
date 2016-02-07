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
namespace Test\Nia\Routing\Condition;

use PHPUnit_Framework_TestCase;
use Nia\Routing\Condition\OrCompositeCondition;
use Nia\Routing\Condition\NullCondition;
use Nia\Collection\Map\StringMap\Map;
use Nia\RequestResponse\RequestInterface;
use Nia\Routing\Condition\ClosureCondition;
use Nia\Collection\Map\StringMap\MapInterface;

/**
 * Unit test for \Nia\Routing\Condition\OrCompositeCondition.
 */
class OrCompositeConditionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Routing\Condition\OrCompositeCondition::__construct
     * @covers \Nia\Routing\Condition\OrCompositeCondition::addCondition
     * @covers \Nia\Routing\Condition\OrCompositeCondition::getConditions
     */
    public function testMethods()
    {
        $c1 = new NullCondition();
        $c2 = new NullCondition();

        $condition = new OrCompositeCondition([
            $c1
        ]);

        $this->assertEquals([
            $c1
        ], $condition->getConditions());

        $this->assertSame($condition, $condition->addCondition($c2));

        $this->assertEquals([
            $c1,
            $c2
        ], $condition->getConditions());
    }

    /**
     * @covers \Nia\Routing\Condition\OrCompositeCondition::checkCondition
     */
    public function testCheckCondition()
    {
        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue('foobar'));

        $condition = new OrCompositeCondition();
        $this->assertSame(false, $condition->checkCondition($request, new Map()));

        $condition->addCondition(new ClosureCondition(function (RequestInterface $request, MapInterface $context): bool {
            return false;
        }));
        $this->assertSame(false, $condition->checkCondition($request, new Map()));

        $condition->addCondition(new ClosureCondition(function (RequestInterface $request, MapInterface $context): bool {
            return true;
        }));
        $this->assertSame(true, $condition->checkCondition($request, new Map()));
    }
}
