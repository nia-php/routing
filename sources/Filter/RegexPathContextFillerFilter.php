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
 * Filter to fill up the context by using a regex with named patterns to extract data from the request path.
 */
class RegexPathContextFillerFilter implements FilterInterface
{

    /**
     * The using regex to extract path segments.
     *
     * @var string
     */
    private $regex = null;

    /**
     * Constructor.
     *
     * @param string $regex
     *            The using regex to extract path segments.
     */
    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Filter\FilterInterface::filterRequest($request, $context)
     */
    public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
    {
        $matches = [];

        if (preg_match($this->regex, $request->getPath(), $matches)) {
            // extract only named matches.
            $data = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));

            foreach ($data as $name => $value) {
                $context->set($name, $value);
            }
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
        return $response;
    }
}
