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
namespace Nia\Routing\Router;

use Nia\Collection\Map\StringMap\MapInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;
use Nia\Routing\Route\RouteInterface;
use Nia\Routing\Router\Exception\NoRouteMatchedException;

/**
 * Interface for all router implementations.
 * Routers a used to accept a request, delegate it to the first handler with a matching condition and returns a response.
 */
interface RouterInterface
{

    /**
     * Adds a route.
     *
     * @param RouteInterface $route
     *            Route to add.
     * @return RouterInterface Reference to this instance.
     */
    public function addRoute(RouteInterface $route): RouterInterface;

    /**
     * Returns a list with added routes.
     *
     * @return RouteInterface[] List with added routes.
     */
    public function getRoutes(): array;

    /**
     * Handles a request and delegates it to the first route with a matching condition.
     *
     * @param RequestInterface $request
     *            The request.
     * @param MapInterface $context
     *            The context.
     * @throws NoRouteMatchedException If no route was found for the request.
     * @return ResponseInterface The response.
     */
    public function handle(RequestInterface $request, MapInterface $context): ResponseInterface;
}
