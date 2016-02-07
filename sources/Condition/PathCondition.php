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
 * Condition to check if the request has the required path.
 */
class PathCondition implements ConditionInterface
{

    /**
     * The required path.
     *
     * @var string
     */
    private $path = null;

    /**
     * Constructor.
     *
     * @param string $path
     *            The required path.
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\ConditionInterface::checkCondition($request, $context)
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool
    {
        return $this->path === $request->getPath();
    }
}
