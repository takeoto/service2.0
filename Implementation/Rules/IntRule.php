<?php

class IntRule implements RuleInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * {@inheritDoc}
     */
    public function isPassed($value): bool
    {
        $this->errors = [];

        if (!$isPassed = is_int($value)) {
            $this->errors[] = 'Value must be integer!';
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
