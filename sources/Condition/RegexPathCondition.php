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
 * Condition to check if the path matches against a regex.
 */
class RegexPathCondition implements ConditionInterface
{

    /**
     * The using regex to check the request path.
     *
     * @var string
     */
    private $regex = null;

    /**
     * Constructor.
     *
     * @param string $regex
     *            The using regex to check the request path.
     */
    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\ConditionInterface::checkCondition($request, $context)
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool
    {
        return preg_match($this->regex, $request->getPath()) !== 0;
    }
}
