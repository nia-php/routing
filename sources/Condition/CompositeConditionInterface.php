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

/**
 * Interface for all composite condition implementations.
 * Composite conditions are used to combine multiple conditions.
 */
interface CompositeConditionInterface extends ConditionInterface
{

    /**
     * Adds a condition.
     *
     * @param ConditionInterface $condition
     *            The condition to add.
     * @return CompositeConditionInterface Reference to this instance.
     */
    public function addCondition(ConditionInterface $condition): CompositeConditionInterface;

    /**
     * Returns a list with assigned conditions.
     *
     * @return ConditionInterface[] List with assigned conditions.
     */
    public function getConditions(): array;
}
