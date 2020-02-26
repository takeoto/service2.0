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

    /**
     * @var array
     */
    private $errors = [];

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
        $this->errors = [];

        if (!$isPassed = in_array($value, $this->values, $this->strict)) {
            $this->errors[] = 'Value must be one of items: ' . implode(',', $this->values);
        }

        return $isPassed;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
