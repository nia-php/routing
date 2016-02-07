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
 * Logical AND condition.
 */
class CompositeCondition implements CompositeConditionInterface
{

    /**
     * List with added conditions.
     *
     * @var ConditionInterface[]
     */
    private $conditions = [];

    /**
     * Constructor.
     *
     * @param ConditionInterface[] $conditions
     *            List with conditions to add.
     */
    public function __construct(array $conditions = [])
    {
        foreach ($conditions as $condition) {
            $this->addCondition($condition);
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\ConditionInterface::checkCondition($request, $context)
     */
    public function checkCondition(RequestInterface $request, MapInterface $context): bool
    {
        foreach ($this->getConditions() as $condition) {
            if (! $condition->checkCondition($request, $context)) {
                return false;
            }
        }

        return true;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\CompositeConditionInterface::addCondition($condition)
     */
    public function addCondition(ConditionInterface $condition): CompositeConditionInterface
    {
        $this->conditions[] = $condition;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Condition\CompositeConditionInterface::getConditions()
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }
}
