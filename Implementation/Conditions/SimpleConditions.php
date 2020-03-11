<?php

class SimpleConditions implements ConditionsInterface
{
    /**
     * @var ConditionInterface[]
     */
    private $conditions;

    /**
     * Conditions constructor.
     * @param ConditionInterface ...$conditions
     */
    public function __construct(ConditionInterface ...$conditions)
    {
        foreach ($conditions as $condition) {
            $this->conditions[$condition->getName()] = $condition;
        }
    }

    /**
     * @inheritDoc
     */
    public function add(ConditionInterface $condition): ConditionsInterface
    {
        if ($this->has($condition->getName())) {
            throw new \Exception("Condition \"{$condition->getName()}\" already exists!");
        }

        $this->conditions[$condition->getName()] = $condition;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function find(string $id): ConditionInterface
    {
        if (!$this->has($id)) {
            throw new \ReqConditionException("Condition \"$id\" not exists!");
        }

        return $this->conditions[$id];
    }

    /**
     * @inheritDoc
     */
    public function remove(ConditionInterface $condition): void
    {
        unset($this->conditions[$condition->getName()]);
    }

    /**
     * @inheritDoc
     */
    public function replace(ConditionInterface $condition): ConditionsInterface
    {
        $this->conditions[$condition->getName()] = $condition;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->conditions[$id]);
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $fn, bool $immutable = false): ConditionsInterface
    {
        return $immutable ? $this->makeInstance($fn) : $this->applyFilter($fn);
    }

    /**
     * @inheritDoc
     */
    public function each(callable $fn): ConditionsInterface
    {
        foreach ($this->conditions as $key => $item) {
            if ($fn($item, $key) === false) {
                return $this;
            }
        }

        return $this;
    }

    /**
     * Make instance of self
     * @param callable $fn
     * @return $this
     */
    private function makeInstance(callable $fn): self
    {
        $objects = [];

        $this->each(function ($item) use ($fn, $objects) {
            /** @var ConditionInterface $item */
            $fn($item) && $objects[] = $item;
        });

        return new self(...$objects);
    }

    /**
     * Apply filter for current list
     * @param callable $fn
     * @return $this
     */
    private function applyFilter(callable $fn): self
    {
        $this->each(function ($item) use ($fn) {
            /** @var ConditionInterface $item */
            $fn($item) && $this->remove($item);
        });

        return $this;
    }
}
