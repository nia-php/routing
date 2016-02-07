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
namespace Nia\Routing\Condition;

use Nia\Collection\Map\StringMap\MapInterface;
use Nia\RequestResponse\RequestInterface;

/**
 * Interface for all route condition implementations.
 */
interface ConditionInterface
{

    /**
     * Checks the request against this condition.
     *
     * @param RequestInterface $request
     *            The request to check.
     * @param MapInterface $context
     *            The context.
     * @return bool Returns 'true' if the condition is successfully, otherwise 'false' will be returned.
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool;
}
