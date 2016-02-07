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
 * Condition to check if an argument is set.
 */
class ArgumentCondition implements ConditionInterface
{

    /**
     * Name of the argument to check for.
     *
     * @var string
     */
    private $argumentName = null;

    /**
     * Constructor.
     *
     * @param string $argumentName
     *            Name of the argument to check for.
     */
    public function __construct(string $argumentName)
    {
        $this->argumentName = $argumentName;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\ConditionInterface::checkCondition($request, $context)
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool
    {
        return $request->getArguments()->has($this->argumentName);
    }
}
