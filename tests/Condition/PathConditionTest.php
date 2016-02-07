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
use Nia\Routing\Condition\PathCondition;
use Nia\RequestResponse\RequestInterface;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Routing\Condition\PathCondition.
 */
class PathConditionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Routing\Condition\PathCondition::checkCondition
     */
    public function testCheckCondition()
    {
        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue('/foo/bar/'));

        $condition = new PathCondition('/unknown');
        $this->assertSame(false, $condition->checkCondition($request, new Map()));

        $condition = new PathCondition('/foo/bar/');
        $this->assertSame(true, $condition->checkCondition($request, new Map()));
    }
}
