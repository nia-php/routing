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
namespace Test\Nia\Routing\Filter;

use PHPUnit_Framework_TestCase;
use Nia\Routing\Filter\NullFilter;
use Nia\Routing\Filter\Exception\IgnoreFilterException;
use Nia\Collection\Map\StringMap\Map;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;

/**
 * Unit test for \Nia\Routing\Filter\NullFilter.
 */
class NullFilterTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Routing\Filter\NullFilter::filterRequest
     */
    public function testFilterRequest()
    {
        $this->setExpectedException(IgnoreFilterException::class);

        $request = $this->getMock(RequestInterface::class);

        $filter = new NullFilter();
        $filter->filterRequest($request, new Map());
    }

    /**
     * @covers \Nia\Routing\Filter\NullFilter::filterResponse
     */
    public function testFilterResponse()
    {
        $response = $this->getMock(ResponseInterface::class);

        $filter = new NullFilter();
        $this->assertSame($response, $filter->filterResponse($response, new Map()));
    }
}
