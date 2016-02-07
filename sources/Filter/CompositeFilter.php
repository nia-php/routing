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
namespace Nia\Routing\Filter;

use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;
use Nia\Routing\Filter\Exception\IgnoreFilterException;

/**
 * Default composite intercepting filter implementation.
 */
class CompositeFilter implements CompositeFilterInterface
{

    /**
     * List with added filters.
     *
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * Constructor.
     *
     * @param FilterInterface[] $filters
     *            List with filters to add.
     */
    public function __construct(array $filters = [])
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Filter\FilterInterface::filterRequest($request, $context)
     */
    public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
    {
        foreach ($this->getFilters() as $filter) {
            try {
                return $filter->filterRequest($request, $context);
            } catch (IgnoreFilterException $exception) {}
        }

        throw new IgnoreFilterException();
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Filter\FilterInterface::filterResponse($response, $context)
     */
    public function filterResponse(ResponseInterface $response, WriteableMapInterface $context): ResponseInterface
    {
        foreach ($this->getFilters() as $filter) {
            $response = $filter->filterResponse($response, $context);
        }

        return $response;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Filter\CompositeFilterInterface::addFilter($filter)
     */
    public function addFilter(FilterInterface $filter): CompositeFilterInterface
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Filter\CompositeFilterInterface::getFilters()
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
