<?php declare(strict_types=1);

namespace Core;

interface ConditionsInterface
{
    /**
     * Find in list of conditions
     * @param string $name
     * @return ConditionInterface
     */
    public function find(string $name): ConditionInterface;

    /**
     * A check has a condition named
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Add item in to list
     * @param ConditionInterface $condition
     * @return $this
     */
    public function add(ConditionInterface $condition): self;

    /**
     * Remove item from list
     * @param ConditionInterface $condition
     */
    public function remove(ConditionInterface $condition): void;

    /**
     * Replace item with same name
     * @param ConditionInterface $condition
     * @return $this
     */
    public function replace(ConditionInterface $condition): self;

    /**
     * Filter by callable condition
     * @param callable $fn
     * @param bool $immutable
     * @return $this
     */
    public function filter(callable $fn, bool $immutable = false): self;

    /**
     * Apply callback for each item
     * @param callable $fn
     * @return $this
     */
    public function each(callable $fn): self;
}
