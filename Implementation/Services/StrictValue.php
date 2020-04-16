<?php

class StrictValue
{
    private $value;

    /**
     * StrictValue constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function asInt(): int
    {
        return (int)$this->value;
    }

    /**
     * @return bool
     */
    public function asBool(): bool
    {
        return (bool)$this->value;
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return (array)$this->value;
    }

    /**
     * @return mixed
     */
    public function original()
    {
        return $this->value;
    }

    /**
     * @param string $class
     * @return {$class}
     * @throws Exception
     */
    public function asInstanceOf(string $class)
    {
        if (!is_a($this->value, $class)) {
            throw new \Exception("Value must be instance of \"$class\"!");
        }

        return $this->value;
    }
}
