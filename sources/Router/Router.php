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

use Nia\Collection\Map\StringMap\Map;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;
use Nia\Routing\Filter\Exception\IgnoreFilterException;
use Nia\Routing\Route\RouteInterface;
use Nia\Routing\Router\Exception\NoRouteMatchedException;

/**
 * Default router implementation.
 */
class Router implements RouterInterface
{

    /**
     * List with added routes.
     *
     * @var RouteInterface[]
     */
    private $routes = [];

    /**
     * Constructor.
     *
     * @param RouteInterface[] $routes
     *            List with routes to add.
     */
    public function __construct(array $routes = [])
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Router\RouterInterface::addRoute($route)
     */
    public function addRoute(RouteInterface $route): RouterInterface
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Router\RouterInterface::getRoutes()
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Router\RouterInterface::handle($request, $context)
     */
    public function handle(RequestInterface $request, MapInterface $context): ResponseInterface
    {
        foreach ($this->getRoutes() as $route) {
            if (! $route->getCondition()->checkCondition($request, $context)) {
                continue;
            }

            // create a writeable clone of the passed context to allow communication between filter and handler
            $context = new Map(iterator_to_array($context->getIterator()));

            $filter = $route->getFilter();

            try {
                return $filter->filterRequest($request, $context);
            } catch (IgnoreFilterException $exception) {}

            $response = $route->getHandler()->handle($request, $context);

            return $filter->filterResponse($response, $context);
        }

        throw new NoRouteMatchedException();
    }
}
