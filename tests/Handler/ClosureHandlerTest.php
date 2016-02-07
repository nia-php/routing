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
namespace Test\Nia\Routing\Handler;

use PHPUnit_Framework_TestCase;
use Nia\Routing\Handler\ClosureHandler;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;
use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Routing\Handler\ClosureHandler.
 */
class ClosureHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Routing\Handler\ClosureHandler::handle
     */
    public function testHandle()
    {
        $response = $this->getMock(ResponseInterface::class);

        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->any())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $handler = new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context): ResponseInterface {
            return $request->createResponse();
        });

        $this->assertSame($response, $handler->handle($request, new Map()));
    }
}
