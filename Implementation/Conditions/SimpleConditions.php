<?php declare(strict_types=1);

namespace Implementation\Conditions;

use Core\ConditionsInterface;

class SimpleConditions implements ConditionsInterface
{
    /**
     * @var array<string,mixed>
     */
    private array $conditions;

    /**
     * Conditions constructor.
     * @param array $conditions
     */
    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @inheritDoc
     */
    public function add(string $name, $value): ConditionsInterface
    {
        $this->conditions[$name] = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            throw new ReqConditionException("Condition \"$name\" not exists!");
        }

        return $this->conditions[$name];
    }

    /**
     * @inheritDoc
     */
    public function remove(string $name): void
    {
        unset($this->conditions[$name]);
    }

    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        return isset($this->conditions[$name]);
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
        foreach ($this->conditions as $key => $value) {
            if ($fn($value, $key) === false) {
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
        $data = [];

        $this->each(function ($value, $key) use ($fn, $data) {
            /** @var mixed $value */
            $fn($value, $key) && $data[$key] = $value;
        });

        return new self($data);
    }

    /**
     * Apply filter for current list
     * @param callable $fn
     * @return $this
     */
    private function applyFilter(callable $fn): self
    {
        $this->each(function ($value, $key) use ($fn) {
            !$fn($value, $key) && $this->remove($key);
        });

        return $this;
    }
}
