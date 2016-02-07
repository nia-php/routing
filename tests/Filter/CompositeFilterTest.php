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
use Nia\Routing\Filter\CompositeFilter;
use Nia\Routing\Filter\FilterInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\Collection\Map\StringMap\Map;
use Nia\Routing\Filter\NullFilter;
use Nia\Routing\Filter\Exception\IgnoreFilterException;
use Nia\RequestResponse\ResponseInterface;
use Nia\Collection\Map\StringMap\WriteableMapInterface;

/**
 * Unit test for \Nia\Routing\Filter\CompositeFilter.
 */
class CompositeFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \Nia\Routing\Filter\CompositeFilter::__construct
     * @covers \Nia\Routing\Filter\CompositeFilter::addFilter
     * @covers \Nia\Routing\Filter\CompositeFilter::getFilters
     */
    public function testComposite()
    {
        $f1 = $this->getMock(FilterInterface::class);
        $f2 = $this->getMock(FilterInterface::class);

        $filter = new CompositeFilter([
            $f1
        ]);
        $this->assertEquals([
            $f1
        ], $filter->getFilters());

        $this->assertSame($filter, $filter->addFilter($f2));
        $this->assertEquals([
            $f1,
            $f2
        ], $filter->getFilters());
    }

    /**
     * @covers \Nia\Routing\Filter\CompositeFilter::filterRequest
     */
    public function testFilterRequest()
    {
        $response = $this->getMock(ResponseInterface::class);
        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->any())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $f1 = new NullFilter();
        $f2 = new class() implements FilterInterface {

            public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
            {
                return $request->createResponse();
            }

            public function filterResponse(ResponseInterface $response, WriteableMapInterface $context): ResponseInterface
            {
                return $response;
            }
        };

        $filter = new CompositeFilter([
            $f1,
            $f2
        ]);

        $this->assertSame($response, $filter->filterRequest($request, new Map()));
    }

    /**
     * @covers \Nia\Routing\Filter\CompositeFilter::filterRequest
     */
    public function testFilterRequestException()
    {
        $this->setExpectedException(IgnoreFilterException::class);

        $request = $this->getMock(RequestInterface::class);

        $filter = new CompositeFilter();
        $filter->filterRequest($request, new Map());
    }

    /**
     * @covers \Nia\Routing\Filter\CompositeFilter::filterResponse
     */
    public function testFilterResponse()
    {
        $response = $this->getMock(ResponseInterface::class);

        $f1 = new NullFilter();
        $f2 = new class() implements FilterInterface {

            public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
            {
                throw IgnoreFilterException;
            }

            public function filterResponse(ResponseInterface $response, WriteableMapInterface $context): ResponseInterface
            {
                return $response;
            }
        };

        $filter = new CompositeFilter([
            $f1,
            $f2
        ]);

        $this->assertSame($response, $filter->filterResponse($response, new Map()));
    }
}
