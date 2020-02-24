<?php

class ArrayOfRule implements RuleInterface
{
    /**
     * @var array
     */
    private $values;
    /**
     * @var bool
     */
    private $strict;

    public function __construct(array $values, bool $strict = false)
    {
        $this->values = $values;
        $this->strict = $strict;
    }

    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        return in_array($value, $this->values, $this->strict);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return ['Value must be one of items: ' . implode(',', $this->values)];
    }
}
