<?php

class BoolRule implements RuleInterface
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

        if (!$isPassed = is_bool($value)) {
            $this->errors[] = 'Value must be boolean!';
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
