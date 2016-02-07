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
 * Interface for all intercepting filter implementations.
 * Intercepting filters are used to modify requests, contexts or to prevent that the from the handler generated response will be send without modifications (like code-injections for tracker or something else).
 */
interface FilterInterface
{

    /**
     * Filters a request before it going to be handled by a handler.
     *
     * @param RequestInterface $request
     *            The request to filter.
     * @param WriteableMapInterface $context
     *            The context.
     * @throws IgnoreFilterException If this filter can be ignored.
     * @return ResponseInterface The response.
     */
    public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface;

    /**
     * Filters a response after the request was handled by a handler.
     *
     * @param ResponseInterface $response
     *            The response to filter.
     * @param WriteableMapInterface $context
     *            The context.
     * @return ResponseInterface The filtered response.
     */
    public function filterResponse(ResponseInterface $response, WriteableMapInterface $context): ResponseInterface;

}
