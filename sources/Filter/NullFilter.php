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
 * Null object filter implementation.
 */
class NullFilter implements FilterInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Filter\FilterInterface::filterRequest($request, $context)
     */
    public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
    {
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
        return $response;
    }
}
