<?php declare(strict_types=1);

namespace Core;

interface ConditionsInterface
{
    /**
     * Find in list of conditions
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * A check has a condition named
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Add item in to list
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function add(string $name, $value): self;

    /**
     * Remove item from list
     * @param string $name
     */
    public function remove(string $name): void;

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
