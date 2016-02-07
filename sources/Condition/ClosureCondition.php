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

use Closure;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\RequestResponse\RequestInterface;

/**
 * Condition which uses a closure to handle the condition.
 */
class ClosureCondition implements ConditionInterface
{

    /**
     * The closure which handles the condition.
     *
     * @var Closure
     */
    private $closure = null;

    /**
     * Constructor.
     *
     * @param Closure $closure
     *            The closure which handles the condition.
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\ConditionInterface::checkCondition($request, $context)
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool
    {
        $closure = $this->closure;

        return $closure($request, $context);
    }
}
