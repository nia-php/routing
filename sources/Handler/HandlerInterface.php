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
namespace Nia\Routing\Handler;

use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;

/**
 * Interface for all route handler implementations.
 */
interface HandlerInterface
{

    /**
     * Handles a response and returns the associated response.
     *
     * @param RequestInterface $request
     *            The response.
     * @param WriteableMapInterface $context
     *            The context.
     * @return ResponseInterface The response.
     */
    public function handle(RequestInterface $request, WriteableMapInterface $context): ResponseInterface;
}
