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
 * Interface for all route implementations.
 */
interface RouteInterface
{

    /**
     * Returns the route condition.
     *
     * @return ConditionInterface The route condition.
     */
    public function getCondition(): ConditionInterface;

    /**
     * Returns the intercepting filter.
     *
     * @return FilterInterface The intercepting filter.
     */
    public function getFilter(): FilterInterface;

    /**
     * Returns the route handler.
     *
     * @return HandlerInterface The route handler.
     */
    public function getHandler(): HandlerInterface;
}
