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
 * Condition to check if the request has the required method.
 */
class MethodCondition implements ConditionInterface
{

    /**
     * The required method.
     *
     * @var string
     */
    private $method = null;

    /**
     * Constructor.
     *
     * @param string $method
     *            The required method.
     */
    public function __construct(string $method)
    {
        $this->method = $method;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\ConditionInterface::checkCondition($request, $context)
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool
    {
        return $this->method === $request->getMethod();
    }
}
