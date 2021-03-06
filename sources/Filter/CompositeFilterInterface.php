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

/**
 * Interface for all composite intercepting filter implementations.
 * Composite filter are used combine multiple intercepting filters.
 * Notice: filterRequest() returns the result first matching interceptor filter if no IgnoreFilterException is thrown, while filterResponse() executes all filters.
 */
interface CompositeFilterInterface extends FilterInterface
{

    /**
     * Adds a filter.
     *
     * @param FilterInterface $filter
     *            The filter to add.
     * @return CompositeFilterInterface Reference to this instance.
     */
    public function addFilter(FilterInterface $filter): CompositeFilterInterface;

    /**
     * Returns a list with assigned filters.
     *
     * @return FilterInterface[] List with assigned filters.
     */
    public function getFilters(): array;
}
