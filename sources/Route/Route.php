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
namespace Nia\Routing\Route;

use Nia\Routing\Condition\ConditionInterface;
use Nia\Routing\Filter\FilterInterface;
use Nia\Routing\Handler\HandlerInterface;

/**
 * Default route implementation.
 */
class Route implements RouteInterface
{

    /**
     * The route condition.
     *
     * @var ConditionInterface
     */
    private $condition = null;

    /**
     * The intercepting filter.
     *
     * @var FilterInterface
     */
    private $filter = null;

    /**
     * The route handler.
     *
     * @var HandlerInterface
     */
    private $handler = null;

    /**
     * Constructor.
     *
     * @param ConditionInterface $condition
     *            The rout condition.
     * @param FilterInterface $filter
     *            The intercepting filter.
     * @param HandlerInterface $handler
     *            The route handler.
     */
    public function __construct(ConditionInterface $condition, FilterInterface $filter, HandlerInterface $handler)
    {
        $this->condition = $condition;
        $this->filter = $filter;
        $this->handler = $handler;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Route\RouteInterface::getCondition()
     */
    public function getCondition(): ConditionInterface
    {
        return $this->condition;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Route\RouteInterface::getFilter()
     */
    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Route\RouteInterface::getHandler()
     */
    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }
}
